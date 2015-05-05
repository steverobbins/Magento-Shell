<?php

/**
 * PHP Terminal formatter
 */
class Local_Shell_Formatter extends Zend_Log_Formatter_Abstract
{
    /**
     * Factory for Local_Shell_Formatter class
     *
     * @param  array|Zend_Config $options
     * @return Local_Shell_Formatter
     */
    public static function factory($options)
    {
        return $this;
    }

    /**
     * Formats data into a single line to be written by the writer.
     *
     * @param  array  $event
     * @return string
     */
    public function format($event)
    {
        return $this->color($event['timestamp'])->dark_gray()
            . str_repeat(' ', 7 - strlen($event['priorityName']))
            . '[' . $this->priorityColor($event['priorityName'], $event['priority']) . '] '
            . $event['message'] . PHP_EOL;
    }

    /**
     * Colorize by zend log level
     *
     * @param  string  $message
     * @param  integer $priority
     * @return Colors_Color
     */
    public function priorityColor($message, $priority)
    {
        switch ($priority) {
            case Zend_Log::INFO:
                return $this->color($message)->green();
            case Zend_Log::NOTICE:
                return $this->color($message)->cyan();
            case Zend_Log::WARN:
                return $this->color($message)->yellow();
            case Zend_Log::ERR:
                return $this->color($message)->red();
            case Zend_Log::CRIT:
                return $this->color($message)->red()->bold();
            case Zend_Log::ALERT:
                return $this->color($message)->white()->bg_red();
            case Zend_Log::EMERG:
                return $this->color($message)->white()->bg_red()->bold()->blink();
        }
        return $this->color($message)->light_green();
    }

    /**
     * Color a string
     *
     * @param  string $message
     * @return Colors_Color
     */
    public function color($message)
    {
        return new Colors_Color($message);
    }
}
