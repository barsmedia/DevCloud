<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('<a href="/phpinfo/' . INFO_CREDITS . '">phpinfo(INFO_CREDITS);</a>');
    return $response;
});

$app->get('/phpinfo/{what}', function (Request $request, Response $response, $args) {
    $what = (int)$args['what'];
    if ($what !== INFO_CREDITS) {
        $what = INFO_CREDITS;
    }

    ob_start();
    phpinfo($what);
    $info = ob_get_contents();
    ob_clean();

    $response->getBody()->write($info);
    return $response;
});

$app->run();
