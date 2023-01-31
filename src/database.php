<?php
namespace src;

/**
 * Класс БД
 */
class Database
{
	private $pdo;

	/**
	 * Метод, который подключает объект PDO к базе данных
	 *
	 * @return \PDO
	 */
	public function connect()
	{
		if ($this->pdo == null)
		{
			$this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
		}
		return $this->pdo;
	}
}