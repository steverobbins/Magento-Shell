<?php
/**
 * Enhanced Shell Scripts
 * 
 * @category   Steverobbins
 * @package    Steverobbins_Shell
 * @author     Steve Robbins <steven.j.robbins@gmail.com>
 * @copyright  Copyright (c) 2014 Steve Robbins (https://github.com/steverobbins)
 * @license    http://creativecommons.org/licenses/by/3.0/deed.en_US Creative Commons Attribution 3.0 Unported License
 */

require_once dirname(__FILE__) . '/../abstract.php';

abstract class Local_Shell_Abstract extends Mage_Shell_Abstract
{
    /**
     * Enable for debug output
     * @var boolean
     */
    protected $_debug = false;

    /**
     * File to log output to, leave blank for no logging
     */
    protected $_logFile = 'shell.log';

    /**
     * Storage for shell colours
     * @var array
     */
    protected $_color = array(
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37'
    );

    /**
     * Storage for shell colours
     * @var array
     */
    protected $_colorBg = array(
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47'
    );

    /**
     * Holds the time execution started
     * @var float
     */
    private $_timeStart;

    /**
     * Captures the execution start time
     *
     * @return void
     */
    public function __construct()
    {
        $this->_timeStart = (float)microtime(true);        
        parent::__construct();
    }

    /**
     * Outputs a message if debuging is enabled
     * 
     * @param  string  $message
     * @param  integer $indent
     * @return void
     */
    public function debug($message, $indent = 0)
    {
        if ($this->_debug) {
            $this->out($this->color($message, 'cyan'), $indent);
        }
    }

    /**
     * Displays a success message
     * 
     * @param  string  $message
     * @param  integer $indent
     * @return void
     */
    public function success($message, $indent = 0)
    {
        if ($this->_debug) {
            $this->out($this->color($message, 'green'), $indent);
        }
    }

    /**
     * Displays an error message
     * 
     * @param  string  $message
     * @param  integer $indent
     * @return void
     */
    public function error($message, $indent = 0)
    {
        $this->out($this->color($message, 'white', 'red'), $indent);
    }

    /**
     * Outputs message to terminal
     * 
     * @param  string  $message
     * @param  integer $indent
     * @return void
     */
    public function out($message, $indent = 0)
    {
        $time = microtime(true) - $this->_timeStart;
        if ($time > 60 * 60) {
            $time /= 60 * 60;
            $stamp = 'h';
        }
        else if ($time  > 60) {
            $time /= 60;
            $stamp = 'm';
        }
        else {
            $stamp = 's';
        }
        $time = str_pad((float)round($time, 3) . ' ' . $stamp, 12);
        $message = str_repeat(' ', $indent * 4) . $message;
        echo $time . $message . PHP_EOL;
        if ($this->_logFile) {
            Mage::log(
                preg_replace('/\\033.?\[([0-9]+|\;?)+m/', '', $message),
                null,
                $this->_logFile,
                true
            );
        }
    }

    /**
     * Display progress notification
     * 
     * @param  integer $step
     * @param  integer $total
     * @param  integer $indent
     * @return void
     */
    public function progress($step, $total, $indent = 0)
    {
        if ($this->_debug) {
            $this->out(
                $this->color(
                    'Progress: ' . $step . '/' . $total . ' ('
                        . round($step / $total * 100, 2) . '%)',
                    'yellow'
                ),
                $indent
            );
        }
    }

    /**
     * Adds color to a string for terminal output
     * 
     * @param  string $string
     * @param  string $foreground
     * @param  string $background
     * @return string
     */
    public function color($string, $foreground = null, $background = null)
    {
        $coloredString = '';
        // Check if given foreground color found
        if (isset($this->_color[$foreground])) {
            $coloredString .= "\033[" . $this->_color[$foreground] . "m";
        }
        // Check if given background color found
        if (isset($this->_colorBg[$background])) {
            $coloredString .= "\033[" . $this->_colorBg[$background] . "m";
        }
        // Add string and end coloring
        $coloredString .=  $string . "\033[0m";
        return $coloredString;
    }
}
