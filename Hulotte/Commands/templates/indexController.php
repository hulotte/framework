<?php

return <<< 'EOD'
<?php

namespace %MODULE_NAME%\Controllers;

use Hulotte\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class IndexController
 * @package %MODULE_NAME%\Controllers
 */
class IndexController
{
    public function __construct(private RendererInterface $renderer)
    {
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@%RENDER_PATH%/index');
    }
}

EOD;
