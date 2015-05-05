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
        'Hacking',
        'Masticating',
        'Recombobulating',
        'Reticulating',
        'Saving',
    );

    /**
     * Do the thing
     *
     * @return void
     */
    public function run()
    {
        $this->log->debug('These are');      usleep(300000);
        $this->log->info('the different');   usleep(300000);
        $this->log->notice('log levels');    usleep(300000);
        $this->log->warn('you can');         usleep(300000);
        $this->log->err('use.  Now');        usleep(300000);
        $this->log->crit('look at');         usleep(300000);
        $this->log->alert('this progress');  usleep(300000);
        $this->log->emerg('bar.');           usleep(300000);
        $count = 10;
        $bar = $this->progressBar($count);
        for ($i = 1; $i <= $count; $i++) {
            usleep(mt_rand(200000, 1000000));
            $bar->update($i, $this->_messages[$i]);
        }
        $bar->finish();
    }
}

$shell = new Local_Shell_SampleScript();
$shell->run();
