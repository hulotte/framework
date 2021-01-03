<?php

// Define autoload path (project or testing)
if (strpos(__DIR__, 'vendor')) {
    $autoload = explode('vendor', __DIR__)[0] . 'vendor/autoload.php';
} else {
    $autoload = dirname(dirname(__DIR__)) . '/vendor/autoload.php';
}

require $autoload;

use Hulotte\App;
use Symfony\Component\Console\Application;

$container = (new App())->getContainer();
$application = new Application();

foreach ($container->get('commands') as $command) {
    $application->add(new $command);
}

$application->run();
