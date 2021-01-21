<?php

use Hulotte\{
    Commands\InitCommand,
    Commands\ModuleCommand,
    Middlewares\RoutingMiddleware,
    Renderer\RendererInterface,
    Renderer\Twig\TwigRendererFactory,
    Routing\RouteDispatcher,
    TwigExtensions\RouterExtension
};
use Psr\Container\ContainerInterface;
use function DI\get;

return [
    \PDO::class => function (ContainerInterface $c) {
        return new \PDO(
            'mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name') . ';charset=utf8',
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    },
    RendererInterface::class => function (ContainerInterface $container) {
        return (new TwigRendererFactory)($container->get('views.path'), 'dev', $container->get('twig.extensions'));
    },
    RoutingMiddleware::class => function (ContainerInterface $container) {
        return new RoutingMiddleware($container->get(RouteDispatcher::class));
    },
    'commands' => [
        InitCommand::class,
        ModuleCommand::class
    ],
    'twig.extensions' => [
        get(RouterExtension::class),
    ],
];
