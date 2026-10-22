<?php

namespace PWE\Exceptions;

use PWE\Core\PWELogger;
use RuntimeException;

/**
 * Description of PHPFatalException
 *
 * @author undera
 */
class PHPFatalException extends RuntimeException
{

    public static function activate()
    {
        return set_error_handler(__CLASS__ . '::errorHandler', E_ALL ^ E_NOTICE);
    }

    public function __construct($errstr, $errno, $errfile, $errline)
    {
        parent::__construct("PHP Error with code $errno: $errstr", 500);
        $this->file = $errfile;
        $this->line = $errline;
    }

    public function __toString()
    {
        $res = parent::__toString();
        $msg = "PHP Error on " . $this->file . ':' . $this->line;
        return $msg . "\n" . $res;
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        // @ prefix masks the error out of error_reporting() (PHP 8 no longer sets it to 0), avoid triggering on @fopen
        if (!(error_reporting() & $errno)) {
            return true;
        }

        // deprecations are only logged, so a newer PHP version does not take pages down
        if ($errno == E_DEPRECATED || $errno == E_USER_DEPRECATED) {
            PWELogger::warn("PHP deprecation: %s in %s:%s", $errstr, $errfile, $errline);
            return true;
        }

        throw new PHPFatalException($errstr, $errno, $errfile, $errline);
    }

}
