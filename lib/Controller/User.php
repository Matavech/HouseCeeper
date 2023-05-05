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

	public function removeUserFromApartmentAdmin()
	{
		global $USER;
		if($USER->IsAdmin())
		{
			$request = Context::getCurrent()->getRequest();
			$userId = 	trim($request->getPost('user-id'));
			$apartmentId = trim($request->getPost('apartment-id'));
			$houseId = trim($request->getPost('house-id'));

			\Hc\Houseceeper\Repository\User::removeUserFromApartment($userId, $apartmentId);

			if (!\Hc\Houseceeper\Repository\User::hasApartments($userId, $houseId))
			{
				\Hc\Houseceeper\Repository\User::removeUserFromHouse($userId, $houseId);
			}
		}
		LocalRedirect('about');
	}

	public static function removeUserFromApartment($userId, $apartmentId, $houseId)
	{
		if (!self::checkAccessToApartment($userId, $apartmentId))
		{
			echo 'Вы не являетесь жильцом этой квартиры!';
			return;
		}

		\Hc\Houseceeper\Repository\User::removeUserFromApartment($userId, $apartmentId);
		if (!\Hc\Houseceeper\Repository\User::hasApartments($userId, $houseId))
		{
			\Hc\Houseceeper\Repository\User::removeUserFromHouse($userId, $houseId);
		}
		LocalRedirect('/profile');
	}

	public static function removeuserFromHouse($userId, $houseId)
	{
		if(\Hc\Houseceeper\Repository\User::hasApartments($userId, $houseId))
		{
			\Hc\Houseceeper\Repository\User::removeUserFromAllApartments($userId, $houseId);
		}
		\Hc\Houseceeper\Repository\User::removeUserFromHouse($userId, $houseId);
		LocalRedirect('/profile');
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

	public static function changeUserGeneralInfoAction($userName, $userLastName, $userLogin)
	{
		$errors = [];
		if (!$userName || !$userLogin)
		{
			$errors[] =  'Не заполнены обязателные поля';
		}
		global $USER;
		if (strlen($userName) > 20 || strlen($userLastName) > 20)
		{
			$errors[] = 'Имя и фамилия не должны быть больше 20 символов';
		}
		if ($USER->GetLogin()!==$userLogin && \CUser::GetByLogin($userLogin) && !\Hc\Houseceeper\Repository\User::checkLoginExists($userLogin))
		{
			$errors[] = 'Логин занят';
		}

		$errorMessage = \Hc\Houseceeper\Repository\User::changeInfo($userName, $userLastName, $userLogin, $USER->GetLogin());
		if (!$errorMessage && !count($errors))
		{
			$userId = $USER->GetID();
			$result = \Hc\Houseceeper\Repository\User::updateUser($userId, $userLogin, $userName, $userLastName);
			if (!is_numeric($result))
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
			foreach (explode('<br>', $errorMessage) as $error)
			{
				if ($error)
				{
					$errors[] = $error;
				}
			}
		}
		if ($errors)
		{
//			$errorMessage = implode('<br>', $errors);
//			LocalRedirect('/profile?errors=' . urlencode($errorMessage));
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile');
		}
		else
		{
			LocalRedirect('/profile');
		}
	}

	public static function getUserAvatar($userId)
	{
		$fileId = \Hc\Houseceeper\Repository\User::getUserAvatarId($userId);
		return $fileId;
	}
}