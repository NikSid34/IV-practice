<?php
namespace App;

/**
 * Класс хранилище отзывов, который содержит методы для взаимодействия с БД
 */
class Feedback
{
	/**
	 * Конструктор
	 *
	 * @param Database $db
	 */
	public function __construct(
		private Database $db
	)
	{}

	/**
	 * Метод, возвращающий отзыв с указанным id
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public function getFeedback(int $id):string
	{
		$sql = "SELECT * FROM feedbacks WHERE id = :id";
		$result = $this->db->query($sql,
			['id' => $id]
		);
		return json_encode($result);
	}

	/**
	 * Метод, возвращающий 20 отзывов, которые находятся на заданной станице
	 *
	 * @param int $page
	 *
	 * @return string
	 */
	public function getPageFeedbacks(int $page, int $count):string
	{
		$page *= 20;
		$sql = "SELECT * FROM feedbacks ORDER BY datetime DESC LIMIT ?, ?";
		$result = $this->db->query($sql,
			[$page, $count]
		);
		return json_encode($result);
	}

	/**
	 * Метод для добавления отзыва
	 *
	 * @param string $name
	 * @param string $text
	 *
	 * @return string
	 */
	public function createFeedback(string $name, string $text):string
	{
		date_default_timezone_set('Europe/Moscow');
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO feedbacks (name, datetime, text)" .
			"VALUES (?, ?, ?)";
		$id = $this->db->createQuery($sql,
			[$name,$date,$text]
		);
		$lastId = "SELECT * FROM feedbacks WHERE id = :id";
		$result = $this->db->query($lastId,
			['id' => $id]
		);
		return json_encode($result);
	}

	/**
	 * Метод для удаления отзыва по id
	 *
	 * @param int $id
	 *
	 * @return void
	 */
	public function deleteFeedback(int $id):void
	{
		$sql = "DELETE FROM feedbacks WHERE id=:id";
		$this->db->query($sql,
			['id' => $id]
		);
	}

	/**
	 * Метод для подсчета отзывов в БД
	 *
	 * @return int
	 */
	public function count():int
	{
		$sql = "SELECT * FROM feedbacks";
		$result = $this->db->query($sql,
			[]
		);
		return count($result);
	}
}