<?php

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Kernel extends HttpKernel
{
    public function __construct(array $routes, ContainerBuilder $container)
    {
        $routesCollection = new RouteCollection();
        foreach ($routes as $r) {
            $route = new Route($r[1]);
            $route->setDefaults(['_controller' => $r[2]]);
            $route->setMethods($r[3]);
            $routesCollection->add($r[0], $route);
        }

        $matcher = new UrlMatcher($routesCollection, new RequestContext());

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

        $controllerResolver = new ControllerResolver($container);
        $argumentResolver = new ArgumentResolver();

        parent::__construct($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);
    }

    /**
     * @return JsonResponse|Response
     *
     * @throws \Throwable
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        try {
            return parent::handle($request, $type, $catch);
        } catch (\Throwable $throwable) {
            if ($throwable instanceof HttpException) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => [
                        $throwable->getMessage(),
                    ],
                ], $throwable->getStatusCode());
            }
            throw $throwable;
        }
    }
}
