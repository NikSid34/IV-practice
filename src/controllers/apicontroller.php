<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Feedback;
use Exception;

class ApiController
{

	/**
	 * Конструктор
	 *
	 * @param Feedback $feedback
	 */
	public function __construct(
		private readonly Feedback $feedback
	)
	{}


	/**
	 * Контроллер, возвращающий Hello world!
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 */
	public function helloWord(Request $request, Response $response, $args):Response
	{
		$response->getBody()->write("Hello world!");
		return $response;
	}


	/**
	 * Контроллер, возвращающий отзыв по id в формате json
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 */
	public function getFeedbackJSON(Request $request, Response $response, $args):Response
	{
		try
		{
			$id = $request->getAttribute('id');
			if (!is_numeric($id) || $id<=0)
			{
				throw new Exception("Param 'id' is not correct");
			}
			$data = $this->feedback->getFeedback($id);
			$response->getBody()->write($data);
			return $response
				->withHeader('Content-Type', 'application/json');
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}


	}


	/**
	 * Контроллер, возвращающий отзывы с постраничной навигацией в формате json
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 */
	public function getPageFeedbacksJSON(Request $request, Response $response, $args):Response
	{
		try
		{
			$params = $request->getQueryParams();
			$page = $params['page'] ?? 1;
			$maxPage = (int)($this->feedback->count()/20);
			if (!is_numeric($page) || $page<=0 || $page>$maxPage)
			{
				throw new Exception("Param 'page' is not correct");
			}
			$page--;
			define("count", 20);
			$data =  $this->feedback->getPageFeedbacks($page, count);
			$response->getBody()->write($data);
			return $response
				->withHeader('Content-Type', 'application/json');
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}
	}

	/**
	 * Контроллер для создания отзыва
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 */
	public function createFeedback(Request $request, Response $response, $args):Response
	{
		try
		{
			$parsedBody = $request->getParsedBody();
			$data = $this->feedback->createFeedback($parsedBody['name'], $parsedBody['text']);
			if ($parsedBody['name']=="" || $parsedBody['text']=="")
			{
				throw new Exception("Not all fields are filled.");
			}
			$response->getBody()->write($data);
			return $response
				->withHeader('Content-Type', 'application/json');
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}
	}


	/**
	 * Контроллер для удаления отзыва
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 */
	public function deleteFeedback(Request $request, Response $response, $args):Response
	{
		try
		{
			$id = $request->getAttribute('id');
			if (!is_numeric($id) || $id<=0)
			{
				throw new Exception("Param 'id' is not correct");
			}
			$this->feedback->deleteFeedback($id);
			return $response
				->withStatus(204);
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}
	}
}