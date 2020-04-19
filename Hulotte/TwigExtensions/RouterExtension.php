<?php

namespace Hulotte\TwigExtensions;

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
     * @var RouteDispatcher
     */
    private $router;

    /**
     * RouterExtension constructor.
     * @param RouteDispatcher $router
     */
    public function __construct(RouteDispatcher $router)
    {
        $this->router = $router;
    }

    /**
     * @return array|TwigFunction[]
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
     * @return mixed
     */
    public function pathFor(string $path, ?array $params = null){
        return $this->router->generateUri($path, $params);
    }
}
