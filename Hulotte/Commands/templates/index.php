<?php

return <<< 'EOD'
<?php

use App\AppModule;
use GuzzleHttp\Psr7\ServerRequest;
use Hulotte\{
    App,
    Middlewares\RoutingMiddleware
};
use function Http\Response\send;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = new App();
$app->addModule(AppModule::class);
$app->setMiddlewares([
    RoutingMiddleware::class,
]);

if (php_sapi_name() !== 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}

EOD;
