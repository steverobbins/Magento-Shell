<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'abstract.php';

abstract class Local_Shell_Abstract extends Mage_Shell_Abstract
{
    /**
     * Zend logger/output
     *
     * @var Zend_Log
     */
    public $log;

    /**
     * Initialize application and parse input parameters
     */
    public function __construct()
    {
        parent::__construct();
        $this->initLog();
    }

    /**
     * Initialize a Zend style logger
     */
    public function initLog()
    {
        $writer = new Zend_Log_Writer_Stream('php://output');
        $writer->setFormatter(new Local_Shell_Formatter());
        $this->log = new Zend_Log($writer);
    }

    /**
     * Create a new Zend style progress bar
     *
     * Example usage:
     *   $count = 10;
     *   $bar = $this->progressBar($count);
     *   for ($i = 1; $i <= $count; $i++) $bar->update($i);
     *   $bar->finish();
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
