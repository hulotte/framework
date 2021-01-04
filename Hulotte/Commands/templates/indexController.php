<?php
return <<< 'EOD'
<?php

namespace %MODULE_NAME%\Controllers;

use Hulotte\Renderer\RendererInterface;

/**
 * Class IndexController
 * @package %MODULE_NAME%\Controllers
 */
class IndexController
{
    public function __construct(private RendererInterface $renderer)
    {
    }

    public function __invoke(): string
    {
        return $this->renderer->render('@%RENDER_PATH%/index');
    }
}

EOD;
