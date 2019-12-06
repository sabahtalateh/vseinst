<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require (__DIR__) . '/src/config/bootstrap.php';

return ConsoleRunner::createHelperSet($container->get('em'));
