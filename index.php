<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use src\Feedback;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

/**
 * Контроллер, возвращающий Hello world!
 */
$app->get('/', function (Request $request, Response $response, $args)
{
	$response->getBody()->write("Hello world!");
	return $response;
});

$app->run();