<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Context;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\UserRoleTable;

class Auth extends Engine\Controller
{
	public static function signin() {
		$request = Context::getCurrent()->getRequest();
		$login = trim($request->getPost('login'));
		$password = trim($request->getPost('password'));

		global $USER;

		if (!is_object($USER))
			$USER = new \CUser();

		$errorMessage = $USER->Login($login, $password, "Y");

		if (is_bool($errorMessage) && $errorMessage){
			LocalRedirect('/');
		} else {
			$APPLICATION = new \CMain();
			$APPLICATION->IncludeComponent('hc:sign.in', '', [
				'error' => $errorMessage,
			]);
		}
	}

	public static function signupUser() {
		$request = Context::getCurrent()->getRequest();
		$login = 	trim($request->getPost('login'));
		$password = trim($request->getPost('password'));
		$name = 	trim($request->getPost('firstname'));
		$lastname = trim($request->getPost('lastname'));
		$email =	trim($request->getPost('email'));
		$key = 		trim($request->getPost('key'));

		if (strlen($name) > 20 || strlen($lastname) > 20)
		{
			$errors[] = 'Имя и фамилия не могут быть длиннее 20 символов.';
		}
		$apartment = \Hc\Houseceeper\Repository\Apartment::getApartmentFromKey($key);
		if ($apartment)
		{
			$result = \Hc\Houseceeper\Repository\User::registerUser($login, $name, $lastname, $password, $email);
			if (is_numeric($result))
			{
				$userId = $result;
				\Hc\Houseceeper\Repository\User::setRole($userId, $apartment->getHouseId(), 3);
				\Hc\Houseceeper\Repository\Apartment::addUser($apartment->getId(), $userId);
				\Hc\Houseceeper\Repository\Apartment::updateRegKey($apartment);
			}
			else
			{
				foreach (explode('<br>', $result) as $error)
				{
					if ($error)
					{
						$errors[] = $error;
					}
				}
			}
		} else {
			$errors[] = 'Неверный ключ';
		}
		if ($errors)
		{
			$APPLICATION = new \CMain();
			$APPLICATION->IncludeComponent('hc:sign.up', '', [
				'errors' => $errors,
			]);
		}
		else
		{
			LocalRedirect('/');
		}

	}

	public static function addUserToHouse()
	{
		$request = Context::getCurrent()->getRequest();
		$login = 	trim($request->getPost('login'));
		$password = trim($request->getPost('password'));
		$key = 		trim($request->getPost('key'));

		$apartment = \Hc\Houseceeper\Repository\Apartment::getApartmentFromKey($key);
		if ($apartment)
		{
			global $USER;
			if (!is_object($USER))
			{
				$USER = new \CUser();
			}
			$errorMessage = $USER->Login($login, $password, "Y");

			if ($errorMessage)
			{
				foreach (explode('<br>', $errorMessage['MESSAGE']) as $error)
				{
					if ($error)
					{
						$errors[] = $error;
					}
				}

			}
			else
			{
				$userId = $USER->GetID();
				if ($userId)
				{
					\Hc\Houseceeper\Repository\User::setRole($userId, $apartment->getHouseId(), 3);
					\Hc\Houseceeper\Repository\Apartment::addUser($apartment->getId(), $userId);
					\Hc\Houseceeper\Repository\Apartment::updateRegKey($apartment);
					LocalRedirect('/');
				}
			}

		}
		else
		{
			$errors[] = 'Неверный ключ';
		}

		if ($errors)
		{
			$APPLICATION = new \CMain();
			$APPLICATION->IncludeComponent('hc:get.into', '', [
				'errors' => $errors,
			]);
		}
	}

	public static function OnAfterUserLoginHandler(&$fields)
	{

	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}