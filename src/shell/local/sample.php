<?php

require_once 'abstract.php';

class Local_Shell_SampleScript extends Local_Shell_Abstract
{
    protected $_messages = array(
        'Compensating',
        'Conjugating',
        'Creating',
        'Deleting',
        'Editing',
        'Emaciating',
        'Hacking',
        'Masticating',
        'Recombobulating',
        'Reticulating',
        'Saving',
        'Updating',
        'Uploading',
    );

    /**
     * Do the thing
     *
     * @return void
     */
    public function run()
    {
        $this->log->debug('These are');
        $this->log->info('the different');
        $this->log->notice('log levels');
        $this->log->warn('you can');
        $this->log->err('use.  Now');
        $this->log->crit('look at');
        $this->log->alert('this progress');
        $this->log->emerg('bar.');
        $count = 14;
        $bar = $this->progressBar($count);
        for ($i = 1; $i <= $count; $i++) {
            usleep(mt_rand(200000, 1000000));
            $bar->update($i, $this->_messages[mt_rand(0, count($this->_messages) - 1)]);
        }
        $bar->finish();
    }
}

$shell = new Local_Shell_SampleScript();
$shell->run();
