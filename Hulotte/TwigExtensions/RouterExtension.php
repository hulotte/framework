<?php

namespace Hulotte\TwigExtensions;

use Exception;
use Hulotte\Routing\RouteDispatcher;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class RouterExtension
 * @author Sébastien CLEMENT<s.clement@la-taniere.net>
 * @package Hulotte\TwigExtensions
 */
class RouterExtension extends AbstractExtension
{
    /**
     * RouterExtension constructor.
     * @param RouteDispatcher $router
     */
    public function __construct(private RouteDispatcher $router)
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('path', [$this, 'pathFor']),
        ];
    }

    /**
     * @param string $path
     * @param array|null $params
     * @return string
     * @throws Exception
     */
    public function pathFor(string $path, ?array $params = null): string
    {
        return $this->router->generateUri($path, $params);
    }
}
