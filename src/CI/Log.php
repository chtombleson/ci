<?php
namespace CI;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    protected $log;

    public function __construct($name, $log_file)
    {
        $this->log = new Logger($name);
        $this->log->pushHandler(new StreamHandler($log_file));
    }

    public function debug($message, $context = [])
    {
        $this->log->addDebug($message, $context);
    }

    public function info($message, $context = [])
    {
        $this->log->addInfo($message, $context);
    }

    public function notice($message, $context = [])
    {
        $this->log->addNotice($message, $context);
    }

    public function warning($message, $context = [])
    {
        $this->log->addWarning($message, $context);
    }

    public function error($message, $context = [])
    {
        $this->log->addError($message, $context);
    }

    public function critical($message, $context = [])
    {
        $this->log->addCritical($message, $context);
    }

    public function alert($message, $context = [])
    {
        $this->log->addAlert($message, $context);
    }

    public function emergency($message, $context = [])
    {
        $this->log->addEmergency($message, $context);
    }
}
