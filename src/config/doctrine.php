<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/../Entity'], $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = ['url' => $_ENV['DB_URL']];
dump($conn);
die();

return EntityManager::create($conn, $config);
