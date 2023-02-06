<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use App\Feedback;
use App\Controllers\ApiController;
use App\Controllers\ViewController;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$feedback = new Feedback(new App\Database);

$app->group('/api',
	function (RouteCollectorProxy $group) use ($feedback)
	{
		$apiController = new ApiController($feedback);

		/**
		 * Маршрут, возвращающий Hello world!
		 */
		$group->get('/hello', $apiController->helloWord(...))->setName('helloWord');

		/**
		 * Маршрут, возвращающий отзыв по id в формате json
		 */
		$group->get('/feedbacks/{id}', $apiController->getFeedbackJSON(...))->setName('getFeedbackJSON');

		/**
		 * Маршрут, возвращающий отзывы с постраничной навигацией в формате json
		 */
		$group->get('/feedbacks', $apiController->getPageFeedbacksJSON(...))->setName('getPageFeedbacksJSON');

		/**
		 * Маршрут для создания отзыва
		 */
		$group->post('/create', $apiController->createFeedback(...))->setName('createFeedback');

		/**
		 * Маршрут для удаления отзыва
		 */
		$group->post('/delete/{id}', $apiController->deleteFeedback(...))->setName('deleteFeedback');

	});


$app->group('/view',
	function (RouteCollectorProxy $group) use ($feedback)
	{
		$viewController = new ViewController($feedback);

		/**
		 * Маршрут, возвращающий отзыв по id
		 */
		$group->get('/feedbacks/{id}', $viewController->getFeedback(...))->setName('getFeedback');

		/**
		 * Маршрут, возвращающий отзывы с постраничной навигацией
		 */
		$group->get('/feedbacks', $viewController->getPageFeedbacks(...))->setName('getPageFeedbacks');
	});


/**
 * Маршрут, для перенаправления к таблице отзывов
 */
$app->get('/', function (Request $request, ResponseInterface $response, $args)
{
	return $response
		->withHeader('Location', '/view/feedbacks')->withStatus(302);
});


$app->run();