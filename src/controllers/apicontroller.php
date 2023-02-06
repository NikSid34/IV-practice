<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Feedback;

class ApiController
{

	/**
	 * Конструктор
	 *
	 * @param Feedback $feedback
	 */
	public function __construct(
		private Feedback $feedback
	)
	{}


	/**
	 * Контроллер, возвращающий Hello world!
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 */
	public function helloWord(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$response->getBody()->write("Hello world!");
		return $response;
	}


	/**
	 * Контроллер, возвращающий отзыв по id в формате json
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 */
	public function getFeedbackJSON(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$id = $request->getAttribute('id');
		$data = $this->feedback->getFeedback($id);
		$response->getBody()->write($data);
		return $response
			->withHeader('Content-Type', 'application/json');
	}


	/**
	 * Контроллер, возвращающий отзывы с постраничной навигацией в формате json
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 */
	public function getPageFeedbacksJSON(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$page = $_GET['page'] ?? 0;
		define("count", 20);
		$data =  $this->feedback->getPageFeedbacks($page, count);
		$response->getBody()->write($data);
		return $response
			->withHeader('Content-Type', 'application/json');
	}


	/**
	 * Контроллер для создания отзыва
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 */
	public function createFeedback(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$parsedBody = $request->getParsedBody();
		$data = $this->feedback->createFeedback($parsedBody['name'], $parsedBody['text']);
		$response->getBody()->write($data);
		return $response
			->withHeader('Content-Type', 'application/json');
	}


	/**
	 * Контроллер для удаления отзыва
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 */
	public function deleteFeedback(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$id = $request->getAttribute('id');
		$this->feedback->deleteFeedback($id);
		return $response
			->withStatus(204);
	}
}