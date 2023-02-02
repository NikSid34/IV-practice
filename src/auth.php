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
			setcookie('error', '', time()-3600);
		}
		else
		{
			setcookie('error', 'Неверный логин или пароль!', time()+3600);
		}
	}

	/**
	 * Метод для выхода из аккаунта

	 * @return void
	 */
	public static function logOut()
	{
		session_start();
		session_destroy();
	}

}