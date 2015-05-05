<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'abstract.php';

abstract class Local_Shell_Abstract extends Mage_Shell_Abstract
{
    /**
     * The name of the log file.
     *
     * If not set, a default will be used, i.e.
     *
     *   $ php myScript.php
     *
     * will log to `var/log/shell_local_myScript.log`
     *
     * @var string
     */
    public $logFile;

    /**
     * Magic Zend logger/output
     *
     * Use any of the Zend_Log constants as strtolower methods.  i.e. for
     * Zend_Log::DEBUG
     *
     *     $this->log->debug($message)
     *
     * For Zend_Log::ERR
     *
     *     $this->log->err($message)
     *
     * @var Zend_Log
     */
    public $log;

    /**
     * Script execution start time
     *
     * @var double
     */
    protected $_timeStart;

    /**
     * Memory used at script start
     *
     * @var integer
     */
    protected $_memoryUsageStart;

    /**
     * Readable memory units
     *
     * @var array
     */
    protected $_memoryUnits = array(
        'bytes',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB',
        'ZB',
        'YB'
    );

    /**
     * Initialize application and parse input parameters
     */
    public function __construct()
    {
        $this->_timeStart        = (float) microtime(true);
        $this->_memoryUsageStart = $this->getMemoryUsage();
        parent::__construct();
        $this->initLog();
        $this->log->debug('== Script execution started ==');
    }

    /**
     * Show execution time
     */
    public function __destruct()
    {
        if (!$this->log) {
            return;
        }
        $this->log->debug(
            'Complete in '
            . round(microtime(true) - $this->_timeStart, 3)
            . ' seconds.  '
            . $this->getMemoryUsageNow()
            . ' of memory used.'
        );
        $this->log->debug('== Script execution completed ==');
    }

    /**
     * Returns the memory usage in bytes at this point
     *
     * @return string
     */
    public function getMemoryUsageNow()
    {
        return $this->_formatSize(
            max($this->getMemoryUsage() - $this->_memoryUsageStart, 0)
        );
    }

    /**
     * Returns the memory usage in bits
     *
     * @return integer
     */
    public function getMemoryUsage()
    {
        return memory_get_usage();
    }

    /**
     * Formats bits into bytes
     *
     * @param  string $size
     * @return string
     */
    protected function _formatSize($size)
    {
        $i = floor(log($size, 1024));
        return $size
            ? round($size / pow(1024, $i), 2) . ' ' . $this->_memoryUnits[$i]
            : '0 ' . $this->_memoryUnits[0];
    }

    /**
     * Initialize a Zend style logger
     */
    public function initLog()
    {
        // Output to shell
        $writer = new Zend_Log_Writer_Stream('php://output');
        $writer->setFormatter(new Local_Shell_Formatter);
        $this->log = new Zend_Log($writer);

        // Log to file
        if (!$this->logFile) {
            $bits = explode('/', $GLOBALS['argv'][0]);
            $bits = explode('.', $bits[count($bits) - 1]);
            $this->logFile = 'shell_local_' . $bits[0] . '.log';
        }
        $logDir  = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . $this->logFile;
        if (!is_dir($logDir)) {
            mkdir($logDir);
            chmod($logDir, 0777);
        }
        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
            chmod($logFile, 0777);
        }
        $writer    = new Zend_Log_Writer_Stream($logFile);
        $format    = '%timestamp% %priorityName% (%priority%): %message%' . PHP_EOL;
        $formatter = new Zend_Log_Formatter_Simple($format);
        $writer->setFormatter($formatter);
        $this->log->addWriter($writer);
    }

    /**
     * Create a new Zend style progress bar
     *
     * Example usage:
     *     $count = 10;
     *     $bar = $this->progressBar($count);
     *     for ($i = 1; $i <= $count; $i++) $bar->update($i);
     *     $bar->finish();
     *
     * @param  integer $batches
     * @param  integer $start
     * @return Zend_ProgressBar
     */
    public function progressBar($batches, $start = 0)
    {
        return new Zend_ProgressBar(
            new Zend_ProgressBar_Adapter_Console(
                array(
                    'elements' => array(
                        Zend_ProgressBar_Adapter_Console::ELEMENT_PERCENT,
                        Zend_ProgressBar_Adapter_Console::ELEMENT_BAR,
                        Zend_ProgressBar_Adapter_Console::ELEMENT_ETA,
                        Zend_ProgressBar_Adapter_Console::ELEMENT_TEXT
                    )
                )
            ),
            $start,
            $batches
        );
    }
}
