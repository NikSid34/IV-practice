<?php
namespace src;

/**
 * Класс для простой аутентификации
 */
class Auth
{
	/**
	 * Метод для входа в аккаунт
	 *
	 * @param string $login
	 * @param string $password
	 *
	 * @return void
	 */
	public static function logIn(string $login, string $password)
	{
		if($login == Config::ADMIN_LOGIN && $password == Config::ADMIN_PASSWORD)
		{
			session_start();
			$_SESSION['login'] = $login;
			header('Location: /feedbacks ');
		}
	}

	/**
	 * Метод для выхода из аккаунта

	 * @return void
	 */
	public static function logOut()
	{
		session_destroy();
		header('Location: /feedbacks ');
	}

}