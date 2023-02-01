<?php
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use src\Feedback;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

/**
 * Контроллер, возвращающий Hello world!
 */
$app->get('/', function (Request $request, ResponseInterface $response, $args)
{
	$response->getBody()->write("Hello world!");
	return $response;
});

/**
 * Контроллер, возвращающий отзыв по id
 */
$app->get('/api/feedbacks/{id}', function (Request $request, ResponseInterface $response, $args)
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
$app->get('/api/feedbacks', function (Request $request, ResponseInterface $response, $args)
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
$app->post('/api/create', function (Request $request, ResponseInterface $response, $args)
{
	$body = $request->getBody();
	$data = json_decode($body, true);
	$data = (new Feedback())->createFeedback($data['name'], $data['text']);
	$payload = json_encode($data);
	$response->getBody()->write($payload);
	return $response
		->withHeader('Content-Type', 'application/json');
});

/**
 * Middleware функция для проверки на логин админа
 *
 * @param Request $request
 * @param RequestHandler $handler
 *
 * @return ResponseInterface
 */
$authAdmin = function (Request $request, RequestHandler $handler) use ($app)
{
	if(!$_SESSION['login'])
	{
		$response = new Response();
		return $response->withHeader('Location', '/login')->withStatus(302);
	}
	else
	{
		$response = $handler->handle($request);
		return $response;
	}
};

/**
 * Контроллер для удаления отзыва
 */
$app->post('/api/delete/{id}', function (Request $request, ResponseInterface $response, $args)
{
	$id = $request->getAttribute('id');
	(new Feedback())->deleteFeedback($id);
})->add($authAdmin);

$app->run();