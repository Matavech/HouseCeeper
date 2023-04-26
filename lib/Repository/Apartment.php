<?php

namespace Hc\Houseceeper\Repository;


use Bitrix\Main\UI\PageNavigation;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;

class Apartment
{
	protected const REG_KEY_LENGTH = 30;
	public static function generateRegKey($houseId, $apartNumber)
	{
		global $USER;
		if (!$USER->IsAdmin() && !\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $houseId))
		{
			LocalRedirect('/');
		}

		$query = HouseTable::getById($houseId);
		$house = $query->fetch();
		if ($house)
		{
			if (!is_numeric($apartNumber) || $apartNumber < 1 || $apartNumber > $house['NUMBER_OF_APARTMENT'])
			{
				return 'Неверный номер квартиры';
			}

			$apartment = ApartmentTable::getList([
				'select' => ['REG_KEY'],
				'filter' => [
					'HOUSE_ID' => $houseId,
					'NUMBER' => $apartNumber
				]
			])->fetchObject();

			if (!$apartment)
			{
				$newRegKey = bin2hex(random_bytes(self::REG_KEY_LENGTH / 2));
				$result = ApartmentTable::add([
					'HOUSE_ID' => $houseId,
					'NUMBER' => $apartNumber,
					'REG_KEY' => $newRegKey,
				]);

				if ($result->isSuccess())
				{
					return 'bitrix.dev.bx/sign-up?key=' . $newRegKey;
				}
			}
			return 'bitrix.dev.bx/sign-up?key=' . $apartment->get('REG_KEY');
		}
		return 'Дом не найден';
	}

	public static function getApartmentFromKey($key)
	{
		$query = ApartmentTable::getList([
			'select' => ['*'],
			'filter' => [
				'=REG_KEY' => $key
			]
		]);

		return $query->fetchObject();
	}

	public static function updateRegKey($apartment)
	{
		$apartment->set('REG_KEY', bin2hex(random_bytes(self::REG_KEY_LENGTH / 2)));
		$apartment->save();
	}

	public static function getApartmentList($houseId, $navObject)
	{
		$apartmentList = ApartmentTable::query()
			->setSelect(['*'])
			->setFilter(['HOUSE_ID' => $houseId])
			->setOrder(['NUMBER' => 'ASC']);

		$navObject->setRecordCount(count($apartmentList->fetchAll()));

		$apartmentList->setOffset($navObject->getOffset())
			->setLimit($navObject->getLimit());

		$apartmentIdList = [];
		foreach ($apartmentList->fetchAll() as $apartment) {
			$apartmentIdList[] = $apartment['ID'];
		}

		$userList = ApartmentUserTable::getList([
			'select' => ['APARTMENT_ID', 'USER.NAME', 'USER.LAST_NAME'],
			'filter' => ['@APARTMENT_ID' => $apartmentIdList]
		])->fetchAll();

		$concatResult = [];

		foreach ($apartmentList->fetchAll() as $apartment) {
			$apartmentId = $apartment['ID'];
			$concatResult[$apartmentId]['NUMBER'] = $apartment['NUMBER'];
			$concatResult[$apartmentId]['LINK'] = 'bitrix.dev.bx/sign-up?key=' . $apartment['REG_KEY'];
		}

		foreach ($userList as $user){
			$apartmentId = $user['APARTMENT_ID'];
			$concatResult[$apartmentId]['USERS'][] =
				$user['HC_HOUSECEEPER_MODEL_APARTMENT_USER_USER_NAME'] . ' ' .
				$user['HC_HOUSECEEPER_MODEL_APARTMENT_USER_USER_LAST_NAME'];
		}



		return $concatResult;
	}
}