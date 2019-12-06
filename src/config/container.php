<?php

use App\Controller\FixtureController;
use App\Controller\OrderController;
use App\Controller\ProductsController;
use App\Kernel;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Request\Order\CreateOrderRequestTransformer;
use App\Request\Order\PayOrderRequestTransformer;
use App\Service\FixtureService;
use App\Service\OrderService;
use App\Service\ProductService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$routes = require(__DIR__).'/routes.php';
$entityManager = require(__DIR__).'/doctrine.php';

$containerBuilder = new ContainerBuilder();

// Doctrine Entity Manager
$containerBuilder->set('em', $entityManager);

// Controllers
$containerBuilder->register(FixtureController::class, FixtureController::class)->setArguments([$containerBuilder]);
$containerBuilder->register(ProductsController::class, ProductsController::class)->setArguments([$containerBuilder]);
$containerBuilder->register(OrderController::class, OrderController::class)->setArguments([$containerBuilder]);

// Repository
$gg = $containerBuilder->register(ProductRepository::class, ProductRepository::class)->setArguments([$entityManager]);
$gg = $containerBuilder->register(OrderRepository::class, OrderRepository::class)->setArguments([$entityManager]);

// Services
$containerBuilder->register(FixtureService::class, FixtureService::class)
    ->setArguments([new Reference(ProductRepository::class)]);
$containerBuilder->register(ProductService::class, ProductService::class)
    ->setArguments([new Reference(ProductRepository::class)]);
$containerBuilder->register(OrderService::class, OrderService::class)
    ->setArguments([new Reference(OrderRepository::class)]);

// RequestTransformers
$containerBuilder->register(CreateOrderRequestTransformer::class, CreateOrderRequestTransformer::class)
    ->setArguments([new Reference(ProductRepository::class)]);
$containerBuilder->register(PayOrderRequestTransformer::class, PayOrderRequestTransformer::class)
    ->setArguments([new Reference(OrderRepository::class)]);

// Kernel register should be the last one
$containerBuilder->register(Kernel::class, Kernel::class)->setArguments([$routes, $containerBuilder]);

return $containerBuilder;
