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
		$errors = [];

		if (empty($login)){
			$errors[] = 'Введите логин';
		}
		if (empty($password)){
			$errors[] = 'Введите пароль';
		}

		global $USER;
		if (!is_object($USER))
			$USER = new \CUser();

		if(!$errors) {
			$errorMessage = $USER->Login($login, $password, "Y");

			if (is_bool($errorMessage) && $errorMessage) {
				LocalRedirect('/');
			} else {
				$errors[] = $errorMessage['MESSAGE'];
			}
		}
		//$APPLICATION = new \CMain();
		//$APPLICATION->IncludeComponent('hc:sign.in', '', [
		//	'error' => $errorMessage,
		//]);
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/sign-in');
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
//			$APPLICATION = new \CMain();
//			$APPLICATION->IncludeComponent('hc:sign.up', '', [
//				'errors' => $errors,
//			]);
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/sign-up');
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
			var_dump($errorMessage);

			if (!is_bool($errorMessage) || !$errorMessage)
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
					$userRole = \Hc\Houseceeper\Repository\User::getUserRole($userId, $apartment->getHouseId());
					\Hc\Houseceeper\Repository\User::setRole($userId, $apartment->getHouseId(), $userRole);
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
//			$APPLICATION = new \CMain();
//			$APPLICATION->IncludeComponent('hc:get.into', '', [
//				'errors' => $errors,
//			]);
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/get-into');
		}
	}

	public static function changePasswordAction($oldPassword, $newPassword, $confirmPassword)
	{
		global $USER;
		$errors = [];
		if (empty($oldPassword)){
			$errors[] = 'Введите старый пароль';
		}
		if (empty($newPassword)){
			$errors[] = 'Введите новый пароль';
		}
		if (empty($confirmPassword)){
			$errors[] = 'Повторите новый пароль';
		}
		if (!$errors) {
			$errorMessage = $USER->Login($USER->GetLogin(), $oldPassword);
			if (is_bool($errorMessage) && $errorMessage) {
				if ($newPassword === $confirmPassword){
					$user = new \CUser();
					$result = $user->update($USER->GetID(), [
						'PASSWORD' => $newPassword,
						'CONFIRM_PASSWORD' => $confirmPassword
					]);
					if (!$result) {
						$errors[] = $user->LAST_ERROR;
					}
				} else {
					$errors[] = 'Пароли не совпадают';
				}
			} else {
				$errors[] = 'Неверный старый пароль';
			}
		}
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/profile');
	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}