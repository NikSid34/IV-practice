<?php
namespace App;
use PDO;
use PDOException;
use Config\Config;

/**
 * Класс БД
 */
class Database
{
	private PDO $pdo;

	public function __construct()
	{
		try
		{
			$this->pdo = new PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
			$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	 * Метод для выполнения SQL запросов
	 *
	 * @param string $sql
	 * @param array $params
	 *
	 * @return array
	 */
	public function query(string $sql, array $params = []): array
	{
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	/**
	 * Метод для выполнения create SQL запросов
	 *
	 * @param string $sql
	 * @param array $params
	 *
	 * @return string
	 */
	public function createQuery(string $sql, array $params = []): string
	{
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $this->pdo->lastInsertId();
	}
}