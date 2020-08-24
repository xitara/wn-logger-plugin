<?php namespace Xitara\Logger\Classes;

use Illuminate\Support\Facades\Log as OldLogger;

/**
 * summary
 */
class Logger
{
    /**
     * called by all loglevels
     * @autor   m.burghammer@xitara.net
     * @date    2018-10-31T23:56:15+0100
     * @version 0.0.1
     * @since   0.0.1
     * @param   string                   $loglevel  loglevel
     * @param   array                   $arguments 0-> $message, 1 -> description (optional, no array, no object) 2-> key-value array context (optional)
     */
    public static function __callStatic($loglevel, $arguments)
    {
        self::add($arguments[0] ?? 'no_text', $loglevel, $arguments[1] ?? null, $arguments[2] ?? []);
    }

    /**
     * Creates a log record
     * @param string $message Specifies the message text
     * @param string $level Specifies the logging level
     * @param string $description Specifies the log description string
     * @return self
     */
    public static function add($message, $level = 'info', $description, $extra)
    {
        // add file and line
        $backtrace = debug_backtrace();
        $backtrace = $backtrace[1];
        $extra['file'] = str_replace(base_path(), '', $backtrace['file']);
        $extra['line'] = $backtrace['line'];

        // var_dump($description);

        if (is_string($message) || is_numeric($message)) {
            $message = (($description === null) ? '' : $description . ': ') . $message;
        }

        if (is_object($message)) {
            $message = (array) $message;
        }

        if (is_bool($message)) {
            $message = ($message === true) ? 'true' : 'false';
            $message = (($description === null) ? '' : $description . ': ') . $message;
        }

        OldLogger::$level($message, $extra);
    }
}
