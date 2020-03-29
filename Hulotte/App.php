<?php

namespace Hulotte;

use DI\ContainerBuilder;
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
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string[]
     */
    private $modules;

    /**
     * @param string $module
     * @return $this
     */
    public function addModule(string $module): self
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * @return ContainerInterface
     * @throws \Exception
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(__DIR__, '/config.php');

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
     * @throws \Exception
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }

        $middlewares = $this->getContainer()->get('middlewares');
        $middlewaresInstanciate = [];

        if (!empty($middlewares)) {
            foreach ($middlewares as $middleware) {
                $middlewaresInstanciate[] = $middleware;
            }
        }

        $dispatcher = new MiddlewareDispatcher($middlewaresInstanciate);

        return $dispatcher->handle($request);
    }
}
