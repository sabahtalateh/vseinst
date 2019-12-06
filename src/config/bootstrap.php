<?php

if (!isset($autoloader)) {
    $autoloader = require dirname(__DIR__).'/../vendor/autoload.php';
}

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/../../.env');

$container = require(__DIR__).'/container.php';

return $container;
