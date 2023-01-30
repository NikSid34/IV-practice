<?php
namespace src;

class Feedback
{
	public static function getReview(int $id)
	{
		$sql = "SELECT * FROM feedback WHERE id = :id";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}

	public static function getAllReviews(int $page)
	{
		$page*=20;
		$sql = "SELECT * FROM feedback ORDER BY datetime DESC LIMIT :page, 20";
		$pdo = (new Database())->connect();
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['page' => $page]);
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

}