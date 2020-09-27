<?php namespace Xitara\Logger\Classes;

use App;
use Illuminate\Support\Facades\Log as OldLogger;
use System\Models\LogSetting;

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
    public static function add($message, $level = 'info', $extra)
    {
        // add file and line
        $backtrace = debug_backtrace();
        $backtrace = $backtrace[1];
        $extra['file'] = str_replace(base_path(), '', $backtrace['file']);
        $extra['line'] = $backtrace['line'];

        // var_dump($description);

        // if (is_string($message) || is_numeric($message)) {
        //     $message = (($description === null) ? '' : $description . ': ') . $message;
        // }

        if (is_object($message)) {
            $message = (array) $message;
        }

        if (is_bool($message)) {
            $message = ($message === true) ? 'true' : 'false';
            // $message = (($description === null) ? '' : $description . ': ') . $message;
        }

        /**
         * write to logger
         */
        OldLogger::$level($message, $extra);

        /**
         * write to database
         */
        if (self::useDatabaseLogging()) {
            try {
                $record = new static;
                $record->message = $message;
                $record->level = $level;

                if ($details !== null) {
                    $record->details = (array) $details;
                }
                $record->save();
            } catch (Exception $ex) {}
        }

        /**
         * cli
         */
        if (php_sapi_name() == 'cli' && self::useCliLogging()) {
            $string = '[' . $level . '] '
                . (is_array($message) ? json_encode($message) : $message)
                . ' [' . $extra['file'] . ':' . $extra['line'] . ']'
                . "\n";

            echo $string;
        }
    }

    /**
     * Returns true if this logger should be used.
     * @return bool
     */
    public static function useLogging()
    {
        return (
            class_exists('Model') &&
            Model::getConnectionResolver() &&
            App::hasDatabase() &&
            !defined('OCTOBER_NO_CUSTOM_LOGGING') &&
            LogSetting::get('log_custom')
        );
    }

    /**
     * Returns true if cli-logging should be used.
     * @return bool
     */
    public static function useCliLogging()
    {
        return (
            class_exists('Model') &&
            // Model::getConnectionResolver() &&
            App::hasDatabase() &&
            !defined('OCTOBER_NO_CLI_LOGGING') &&
            LogSetting::get('log_cli')
        );
    }

    /**
     * Returns true if database-logging should be used.
     * @return bool
     */
    public static function useDatabaseLogging()
    {
        return (
            class_exists('Model') &&
            // Model::getConnectionResolver() &&
            App::hasDatabase() &&
            !defined('OCTOBER_NO_DATABASE_LOGGING') &&
            LogSetting::get('log_database')
        );
    }

}
