<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$log = new Logger('app_logger');
$log->pushHandler(new StreamHandler((__DIR__).'/../../var/log.log', Logger::INFO));

return $log;
