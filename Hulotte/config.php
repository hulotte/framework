<?php

use Hulotte\{
    Middlewares\RoutingMiddleware,
    Renderer\Twig\TwigRendererFactory
};
use Psr\Container\ContainerInterface;

return [
    RendererInterface::class => function (ContainerInterface $c) {
        return (new TwigRendererFactory)($c->get('views.path'), 'dev');
    },
    RoutingMiddleware::class => function (ContainerInterface $c) {
        return new RoutingMiddleware($c->get(RouteDispatcher::class));
    },
    'middlewares' => [],
];
