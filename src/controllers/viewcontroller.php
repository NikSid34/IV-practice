<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Feedback;

class ViewController
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
	 * Контроллер, возвращающий отзыв по id
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 * @throws \Throwable
	 */
	public function getFeedback(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$id = $request->getAttribute('id');
		$data = $this->feedback->getFeedback($id);
		$payload = json_decode($data, true);
		$renderer = new PhpRenderer($_SERVER['DOCUMENT_ROOT'] . '/templates/view');
		return $renderer->render($response, "feedback.php", [
			'feedback' => $payload[0]
		]);
	}


	/**
	 * Контроллер, возвращающий отзывы с постраничной навигацией
	 *
	 * @param Request $request
	 * @param ResponseInterface $response
	 * @param $args
	 *
	 * @return ResponseInterface
	 * @throws \Throwable
	 */
	public function getPageFeedbacks(Request $request, ResponseInterface $response, $args):ResponseInterface
	{
		$page = $_GET['page'] ?? 1;
		$page--;
		$maxPage = (int)($this->feedback->count()/20);
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
}