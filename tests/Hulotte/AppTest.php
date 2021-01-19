<?php

namespace tests\Hulotte;

use Exception;
use Hulotte\App;
use Hulotte\Middlewares\RoutingMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class AppTest
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @covers \Hulotte\App
 * @package tests\Hulotte
 */
class AppTest extends TestCase
{
    /**
     * @var App
     */
    private App $app;

    /**
     * @covers \Hulotte\App::addModules
     * @test
     */
    public function addModules(): void
    {
        $this->app
            ->addModules([
                'namespace\moduleTest',
                'namespace\secondModule',
            ]);
        $modules = $this->app->getModules();

        $this->assertSame('namespace\moduleTest', $modules[0]);
        $this->assertSame('namespace\secondModule', $modules[1]);
    }

    /**
     * @covers \Hulotte\App::getContainer
     * @test
     * @throws Exception
     */
    public function getContainer(): void
    {
        $container = $this->app->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(RoutingMiddleware::class, $container->get(RoutingMiddleware::class));
    }

    protected function setUp(): void
    {
        $this->app = new App();
    }
}
