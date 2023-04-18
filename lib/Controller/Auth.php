<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Context;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\UserTable;

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

	public static function signupUser() {
		$request = Context::getCurrent()->getRequest();
		$login = 	trim($request->getPost('login'));
		$password = trim($request->getPost('password'));
		$name = 	trim($request->getPost('firstname'));
		$lastname = trim($request->getPost('lastname'));
		$email =	trim($request->getPost('email'));
		$key = 		trim($request->getPost('key'));

		$apartment = Apartment::getApartmentFromKey($key);
		if ($apartment) {
			global $USER;
			$resultMessage = $USER->Register($login, $name, $lastname, $password, $password, $email);
			if ($resultMessage['TYPE'] === 'OK'){

				$userId = $USER->GetID();
				$USER->Update($userId, [
					"WORK_COMPANY" => 'HouseCeeper'
				]);

				$result = UserTable::add([
					'ID' => $userId,
					'ROLE_ID' => 1
				]);

				if ($result->isSuccess()) {
					$apartId = $apartment['ID'];
					ApartmentUserTable::add([
						'APARTMENT_ID' => $apartId,
						'USER_ID' => $userId,
					]);
					LocalRedirect('/');
				}
			} else {
				ShowMessage($resultMessage);
			}
		}
		echo 'Неверный ключ';
	}

	public static function logout() {
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}