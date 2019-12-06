<?php

$autoloader = require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

$container = require_once dirname(__DIR__) . '/src/config/bootstrap.php';

/** @var Kernel $kernel */
$kernel = $container->get(Kernel::class);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
