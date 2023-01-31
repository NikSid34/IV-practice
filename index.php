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

/**
 * Контроллер, возвращающий отзыв по id
 */
$app->get('/api/feedbacks/{id}', function (Request $request, Response $response, $args)
{
	$id = $request->getAttribute('id');
	$data = (new Feedback())->getFeedback($id);
	$payload = json_encode($data);
	$response->getBody()->write($payload);
	return $response
		->withHeader('Content-Type', 'application/json');
});

/**
 * Контроллер, возвращающий все отзывы с постраничной навигацией
 */
$app->get('/api/feedbacks', function (Request $request, Response $response, $args)
{
	$page = $_GET['page'] ?? 0;
	$data = (new Feedback())->getAllFeedbacks($page);
	$payload = json_encode($data);
	$response->getBody()->write($payload);
	return $response
		->withHeader('Content-Type', 'application/json');
});

/**
 * Контроллер для создания отзыва
 */
$app->post('/api/create', function (Request $request, Response $response, $args)
{
	$body = $request->getBody();
	$data = json_decode($body, true);
	(new Feedback())->createFeedback($data['name'], $data['text']);
});

/**
 * Контроллер для удаления отзыва
 */
$app->post('/api/delete/{id}', function (Request $request, Response $response, $args)
{
	$id = $request->getAttribute('id');
	(new Feedback())->deleteFeedback($id);
});

$app->run();