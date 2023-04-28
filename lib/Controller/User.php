<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;
use Hc\Houseceeper\Model\BUserTable;

class User extends Controller
{
	public function getUserName ($id)
	{
		return \Hc\Houseceeper\Repository\User::getName($id);
	}

	public function deleteHeadman()
	{
		$request = Context::getCurrent()->getRequest();
		$userId = 	trim($request->getPost('headman-id'));
		$houseId = 	trim($request->getPost('house-id'));

		\Hc\Houseceeper\Repository\User::deleteHeadman($userId, $houseId);
		LocalRedirect('about');
	}

	public function addHeadman()
	{
		$request = Context::getCurrent()->getRequest();
		$userId = 	trim($request->getPost('user-id'));
		$houseId = 	trim($request->getPost('house-id'));

		\Hc\Houseceeper\Repository\User::addHeadman($userId, $houseId);
		LocalRedirect('about');
	}

	public function removeUserFromHouse()
	{
		$request = Context::getCurrent()->getRequest();
		$userId = 	trim($request->getPost('user-id'));
		$houseId = 	trim($request->getPost('house-id'));
		$apartmentId = trim($request->getPost('apartment-id'));

		\Hc\Houseceeper\Repository\User::removeUserFormHouse($userId, $houseId, $apartmentId);
		LocalRedirect('about');
	}

	public static function checkAccessToHouse()
	{
		$housePath = $_REQUEST['housePath'];
		$houseId = \Hc\Houseceeper\Repository\House::getIdByPath($housePath);

		if (!$houseId)
		{
			echo 'Дома '. $housePath . ' не существует!';
			return;
		}

		global $USER;
		$userId = $USER->GetID();

		if (!\Hc\Houseceeper\Repository\User::hasAccessToHouse($userId, $houseId))
		{
			LocalRedirect('/');
		}
	}

	public static function checkAccessToApartment($userId, $apartmentId)
	{

		if (\Hc\Houseceeper\Repository\User::findUserApartment($userId, $apartmentId))
		{
			return True;
		}
		return False;

	}

	public static function getUserGeneral($USER)
	{
		$result['LOGIN'] = $USER->GetLogin();
		$result['NAME'] = $USER->GetFirstName();
		$result['LAST_NAME'] = $USER->GetLastName();
		$result['ID']= $USER->GetID();

		return $result;
	}

	public static function changeUserGeneralInfo($userName, $userLastName, $userLogin)
	{
		if (!$userName || !$userLogin)
		{
			echo 'Не заполнены обязательные поля';
			return;
		}
		global $USER;
		if ($USER->GetLogin()!==$userLogin && \CUser::GetByLogin($userLogin) && !\Hc\Houseceeper\Repository\User::checkLoginExists($userLogin))
			{
				echo 'Логин занят';
				return;
			}
		$errorMessage = \Hc\Houseceeper\Repository\User::changeInfo($userName, $userLastName, $userLogin, $USER->GetLogin());
		if (!$errorMessage)
		{
			$userId = $USER->GetID();
			$USER->Update($userId, [
				'LOGIN' => $userLogin,
				'NAME' => $userName,
				'LAST_NAME' => $userLastName,
			]);
			return True;
		}

		return $errorMessage;
	}

	public static function deleteUserFromApartment($userId, $apartmentId)
	{
		if (!self::checkAccessToApartment($userId, $apartmentId))
		{
			echo 'Вы не являетесь жильцом этой квартиры!';
			return;
		}

		$houseId = \Hc\Houseceeper\Repository\Apartment::getHouseIdByApartmentId($apartmentId);
		$housePath = \Hc\Houseceeper\Repository\House::getPathById($houseId);
		$apartments =  \Hc\Houseceeper\Repository\House::getUserApartmentNumber($userId, $housePath);
		if (count($apartments)===1)
		{
			\Hc\Houseceeper\Repository\User::removeUserFormHouse($userId, $houseId, $apartments[0]);
			return;
		}
		\Hc\Houseceeper\Repository\User::leaveApartment($userId, $apartmentId);
	}

}