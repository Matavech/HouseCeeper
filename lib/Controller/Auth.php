<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Hc\Houseceeper\Repository;

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

		LocalRedirect('/');
	}

	public static function signupUser() {

	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}