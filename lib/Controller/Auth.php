<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Context;
use Bitrix\Main\Security\Password;
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
			ShowMessage($errorMessage);
		}
	}

//	 public static function changePassword($userLogin, $oldPassword, $newPassword, $confirmPassword)
//	 {
//	 		global $USER;
//	 		if (!is_object($USER))
//	 		{
//	 			$USER = new \CUser();
//	 		}
//	 		$USER->Login($userLogin, $oldPassword, "Y");
//	 		$userId = $USER->GetID();
//	 		if ($userId)
//	 		{
//	 			var_dump($USER->ChangePassword($userLogin, $checkword, $newPassword, $confirmPassword)); die;
//
//	 				$USER->Login($userLogin, $newPassword);
//	 				LocalRedirect('/');
//
//	 			echo 'something wrong';
//	 		}
//
//	 }

	public static function changePassword($oldPassword, $newPassword, $confirmPassword)
	{
		global $USER;
		$errorMessage = $USER->Login($USER->GetLogin(), $oldPassword);
		if (is_bool($errorMessage) && $errorMessage) {
			if ($newPassword === $confirmPassword){
				$user = new \CUser();
				$user->update($USER->GetID(), [
					'PASSWORD' => $newPassword,
					'CONFIRM_PASSWORD' => $confirmPassword
				]);
				LocalRedirect('/profile');
			} else {
				echo 'Пароли не совпадают';
			}
		} else {
			echo 'Неверный старый пароль';
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

		$apartment = \Hc\Houseceeper\Repository\Apartment::getApartmentFromKey($key);
		if ($apartment)
		{
			$userId = \Hc\Houseceeper\Repository\User::registerUser($login, $name, $lastname, $password, $email);
			if ($userId)
			{
				\Hc\Houseceeper\Repository\User::setRole($userId, $apartment->getHouseId(), 3);
				\Hc\Houseceeper\Repository\Apartment::addUser($apartment->getId(), $userId);
				\Hc\Houseceeper\Repository\Apartment::updateRegKey($apartment);
				LocalRedirect('/');
			}
		} else {
			echo 'Неверный ключ';
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
			$userId = $USER->GetID();
			if ($userId)
			{
				\Hc\Houseceeper\Repository\User::setRole($userId, $apartment->getHouseId(), 3);
				\Hc\Houseceeper\Repository\Apartment::addUser($apartment->getId(), $userId);
				\Hc\Houseceeper\Repository\Apartment::updateRegKey($apartment);
				LocalRedirect('/');
			}
		} else {
			echo 'Неверный ключ';
		}
	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}