<?php
namespace src;

class Feedback
{

	public static function getFeedback(int $id)
	{
		$sql = "SELECT * FROM feedbacks WHERE id = :id";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}

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

}