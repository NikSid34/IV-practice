<?php
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use src\Feedback;
use src\Auth;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();


/**
 * Контроллер, возвращающий Hello world!
 */
$app->get('/', function (Request $request, ResponseInterface $response, $args)
{
	$response->getBody()->write("Hello world!");
	return $response;
})->setName('hello');


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
})->setName('feedback');


/**
 * Контроллер, возвращающий все отзывы с постраничной навигацией
 */
$app->get('/api/feedbacks', function (Request $request, ResponseInterface $response, $args)
{
	$page = $_GET['page'] ?? 0;
	$data = (new Feedback())->getAllFeedbacks($page);
	$payload = json_decode($data, true);
	$renderer = new PhpRenderer(__DIR__ . '/templates/view');
	return $renderer->render($response, "feedbacks_table.php", [
		'feedbacks' => $payload,
		'page' => $page
	]);
})->setName('feedbacks');


/**
 * Контроллер для создания отзыва
 */
$app->post('/api/create', function (Request $request, ResponseInterface $response, $args)
{
	$parsedBody = $request->getParsedBody();
	$data = (new Feedback())->createFeedback($parsedBody['name'], $parsedBody['text']);
	return $response
		->withHeader('Location', '/api/feedbacks')->withStatus(302);
})->setName('createFeedback');


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
	session_start();
	if(!isset($_SESSION['login']))
	{
		$response = new Response();
		return $response->withHeader('Location', '/api/login')->withStatus(302);
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
	return $response->withHeader('Location', '/api/feedbacks')->withStatus(302);
})->setName('deleteFeedback')->add($authAdmin);


/**
 * Контроллер для входа в аккаунт
 */
$app->post('/api/login', function (Request $request, ResponseInterface $response, $args)
{
	$parsedBody = $request->getParsedBody();
	Auth::logIn($parsedBody['login'], $parsedBody['password']);
	if (!isset($_COOKIE['error']))
	{
		return $response->withHeader('Location', '/api/feedbacks')->withStatus(302);
	}
	else
	{
		return $response->withHeader('Location', '/api/login')->withStatus(302);
	}
})->setName('loginFunc');


/**
 * Middleware функция для проверки на вход в аккаунт
 *
 * @param Request $request
 * @param RequestHandler $handler
 *
 * @return ResponseInterface
 */
$authCheck = function (Request $request, RequestHandler $handler) use ($app)
{
	session_start();
	if(isset($_SESSION['login']))
	{
		$response = new Response();
		return $response->withHeader('Location', '/api/feedbacks')->withStatus(302);
	}
	else
	{
		$response = $handler->handle($request);
		return $response;
	}
};


/**
 * Контроллер, возвращающий окно для входа в аккаунт
 */
$app->get('/api/login', function (Request $request, ResponseInterface $response, $args)
{
	$renderer = new PhpRenderer(__DIR__ . '/templates/view');
	return $renderer->render($response, "login.php", [
		'feedbacks' => '$payload'
	]);
})->setName('login')->add($authCheck);


/**
 * Контроллер для выхода из аккаунта
 */
$app->get('/api/logout', function (Request $request, ResponseInterface $response, $args)
{
	Auth::logOut();
	return $response->withHeader('Location', '/api/feedbacks')->withStatus(302);
})->setName('logout');


$app->run();