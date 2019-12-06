<?php

namespace App;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyControllerResolver;

class ControllerResolver extends SymfonyControllerResolver
{
    private $container;

    public function __construct(ContainerBuilder $container, LoggerInterface $logger = null)
    {
        $this->container = $container;
        parent::__construct($logger);
    }

    protected function instantiateController(string $class)
    {
        return $this->container->get($class);
    }
}
