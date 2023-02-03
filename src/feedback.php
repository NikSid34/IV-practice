<?php
namespace src;

/**
 * Класс хранилище отзывов, который содержит методы для взаимодействия с БД
 */
class Feedback
{
	/**
	 * Метод, возвращающий отзыв с указанным id
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getFeedback(int $id)
	{
		$sql = "SELECT * FROM feedbacks WHERE id = :id";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		$result = json_encode($result);
		return $result;
	}

	/**
	 * Метод, возвращающий 20 отзывов, которые находятся на заданной станице
	 *
	 * @param int $page
	 *
	 * @return string
	 */
	public static function getAllFeedbacks(int $page)
	{
		$page*=20;
		$sql = "SELECT * FROM feedbacks ORDER BY datetime DESC LIMIT :page, 20";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['page' => $page]);
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		$result = json_encode($result);
		return $result;
	}

	/**
	 * Метод для добавления отзыва
	 *
	 * @param string $name
	 * @param string $text
	 *
	 * @return string
	 */
	public static function createFeedback(string $name, string $text)
	{
		date_default_timezone_set('Europe/Moscow');
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO feedbacks (name, datetime, text)" .
			"VALUES (?, ?, ?)";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name,$date,$text]);
		$data = $pdo->lastInsertId();
		return $data;
	}

	/**
	 * Метод для удаления отзыва по id
	 *
	 * @param int $id
	 *
	 * @return void
	 */
	public static function deleteFeedback(int $id)
	{
		$sql = "DELETE FROM feedbacks WHERE id=:id";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
	}

	/**
	 * Метод для подсчета отзывов в БД
	 *
	 * @return int
	 */
	public static function count()
	{
		$sql = "SELECT * FROM feedbacks";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		$result = count($result);
		return $result;
	}
}