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
	 * @return array
	 */
	public static function getFeedback(int $id)
	{
		$sql = "SELECT * FROM feedbacks WHERE id = :id";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * Метод, возвращающий 20 отзывов, которые находятся на заданной станице
	 *
	 * @param int $page
	 *
	 * @return array
	 */
	public static function getAllFeedbacks(int $page)
	{
		$page*=20;
		$sql = "SELECT * FROM feedbacks ORDER BY datetime DESC LIMIT :page, 20";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['page' => $page]);
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * Метод для добавления отзыва
	 *
	 * @param string $name
	 * @param string $text
	 *
	 * @return void
	 */
	public static function createFeedback(string $name, string $text)
	{
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO feedbacks (name, datetime, text)" .
			"VALUES (:name, :date, :text)";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['name' => $name, 'datetime' => $date, 'text' => $text]);
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

}