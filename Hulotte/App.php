<?php

namespace Hulotte;

use DI\ContainerBuilder;
use Exception;
use Hulotte\Middlewares\MiddlewareDispatcher;
use Psr\{
    Container\ContainerInterface,
    Http\Message\ResponseInterface,
    Http\Message\ServerRequestInterface
};

/**
 * Class App
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte
 */
class App
{
    /**
     * App constructor
     * @param null|ContainerInterface $container
     * @param string[] $modules
     * @param string[] $middlewares
     */
    public function __construct(
        private ?containerInterface $container = null,
        private array $modules = [],
        private array $middlewares = []
    ) {
    }

    /**
     * @param array $module
     */
    public function addModules(array $module): void
    {
        $this->modules = $module;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(__DIR__ . '/config.php');

            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }

            $this->container = $builder->build();
        }

        return $this->container;
    }

    /**
     * @return string[]
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }

        $middlewaresInstanciate = [];

        if (!empty($this->middlewares)) {
            foreach ($this->middlewares as $middleware) {
                $middlewaresInstanciate[] = $this->container->get($middleware);
            }
        }

        $dispatcher = new MiddlewareDispatcher($middlewaresInstanciate);

        return $dispatcher->handle($request);
    }

    /**
     * @param string[] $middlewares
     */
    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }
}
