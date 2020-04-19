<?php

use Hulotte\{
    Middlewares\RoutingMiddleware,
    Renderer\RendererInterface,
    Renderer\Twig\TwigRendererFactory,
    Routing\RouteDispatcher,
    TwigExtensions\RouterExtension
};
use Middlewares\Whoops;
use Psr\Container\ContainerInterface;
use function DI\get;

return [
    RendererInterface::class => function(ContainerInterface $container){
        return (new TwigRendererFactory)($container->get('views.path'), 'dev', $container->get('twig.extensions'));
    },
    RoutingMiddleware::class => function(ContainerInterface $container){
        return new RoutingMiddleware($container->get(RouteDispatcher::class));
    },
    'middlewares' => [
        new Whoops(),
        get(RoutingMiddleware::class),
    ],
    'twig.extensions' => [
        get(RouterExtension::class),
    ],
];
