<?php

return <<< 'EOD'
<?php

use GuzzleHttp\Psr7\ServerRequest;
use Hulotte\App;
use function Http\Response\send;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = new App();

if (php_sapi_name() !== 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}

EOD;
