<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Feedback;
use Exception;

class ViewController
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
	 * Контроллер, возвращающий отзыв по id
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 * @throws \Throwable
	 */
	public function getFeedback(Request $request, Response $response, $args):Response
	{
		try
		{
			$id = $request->getAttribute('id');
			if (!is_numeric($id) || $id<=0)
			{
				throw new Exception("Param 'id' is not correct");
			}
			$data = $this->feedback->getFeedback($id);
			$payload = json_decode($data, true);
			$renderer = new PhpRenderer($_SERVER['DOCUMENT_ROOT'] . '/templates/view');
			return $renderer->render($response, "feedback.php", [
				'feedback' => $payload[0]
			]);
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}
	}


	/**
	 * Контроллер, возвращающий отзывы с постраничной навигацией
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param $args
	 *
	 * @return Response
	 * @throws \Throwable
	 */
	public function getPageFeedbacks(Request $request, Response $response, $args):Response
	{
		try
		{
			$params = $request->getQueryParams();
			$page = $params['page'] ?? 1;
			$maxPage = (int)($this->feedback->count()/20);
			if (!is_numeric($page) || $page<=0 || $page>$maxPage+1)
			{
				throw new Exception("Param 'page' is not correct");
			}
			$page--;
			define("count", 20);
			$data =  $this->feedback->getPageFeedbacks($page, count);
			$payload = json_decode($data, true);
			$renderer = new PhpRenderer($_SERVER['DOCUMENT_ROOT'] . '/templates/view');
			return $renderer->render($response, "feedbacks_table.php", [
				'feedbacks' => $payload,
				'page' => $page,
				'maxPage' => $maxPage,
			]);
		}
		catch (Exception $e)
		{
			$response->getBody()->write($e->getMessage());
			return $response;
		}
	}
}