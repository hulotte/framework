<?php

return <<< 'EOD'
<?php

namespace %MODULE_NAME%;

use %MODULE_NAME%\Controllers\IndexController;
use Hulotte\{
    Module,
    Renderer\RendererInterface,
    Routing\RouteDispatcher
};
use Psr\Container\ContainerInterface;

/**
 * Class %MODULE_NAME%Module
 * @package %MODULE_NAME%
 */
class %MODULE_NAME%Module extends Module
{
    public const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(ContainerInterface $container, RendererInterface $renderer, RouteDispatcher $router)
    {
        $renderer->addPath('%RENDER_PATH%', $container->get('views.path'));
        $router->addRoute('/', 'accueil', $container->get(IndexController::class));
    }
}
EOD;
