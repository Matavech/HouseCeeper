<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;

class Auth extends Engine\Controller
{
	public static function signin() {
		$login = \Bitrix\Main\Context::getCurrent()->getRequest()->getPost('login');
		$password = \Bitrix\Main\Context::getCurrent()->getRequest()->getPost('password');
		$login = trim($login);
		$password = trim($password);

		global $USER;

		if (!is_object($USER))
			$USER = new \CUser();

		$errorMessage = $USER->Login($login, $password, "Y");

		if (is_bool($errorMessage) && $errorMessage){
			LocalRedirect('/');
		} else {
			var_dump($errorMessage);
			ShowMessage($errorMessage);
		}
	}

	public static function signupUser() {

	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}