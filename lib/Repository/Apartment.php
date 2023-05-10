<?php

namespace Hc\Houseceeper\Repository;


use Bitrix\Main\UI\PageNavigation;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\UserRoleTable;

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
					return $_SERVER['SERVER_NAME'] . '/sign-up?key=' . $newRegKey;
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
			'select' => ['APARTMENT_ID', 'USER.NAME', 'USER.LAST_NAME', 'USER.ID'],
			'filter' => ['@APARTMENT_ID' => $apartmentIdList]
		])->fetchAll();

		return [
			'userList' => $userList,
			'apartmentList' => $apartmentList->fetchAll()
		];
	}

	public static function addUser($apartmentId, $userId)
	{
		ApartmentUserTable::add([
			'APARTMENT_ID' => $apartmentId,
			'USER_ID' => $userId,
		]);
	}

	public static function addApartments($houseId, $numberFrom, $numberTo)
	{
		$apartmentList = [];
		for($i = $numberFrom; $i <= $numberTo; $i++){
			$apartmentList[] = [
				'NUMBER' => $i,
				'HOUSE_ID' => $houseId,
				'REG_KEY' => bin2hex(random_bytes(self::REG_KEY_LENGTH / 2))
			];
		}
		return ApartmentTable::addMulti($apartmentList);
	}

	public static function getApartmentIdFromNumber($number, $houseId)
	{
		$apartment = ApartmentTable::getList([
			'select' => ['*'],
			'filter' => [
				'HOUSE_ID' => $houseId,
				'NUMBER' => $number
			]
		])->fetchObject();
		if ($apartment) {
			return $apartment->getId();
		}

		return false;
	}

	public static function getMaxApartmentNumber($houseId)
	{
		$allApartmens = ApartmentTable::query()
			->setSelect(['*'])
			->setFilter(['HOUSE_ID' => $houseId])
			->fetchCollection();

//		$apartment = ApartmentUserTable::query()
//			->setSelect(['*', 'APARTMENT.NUMBER'])
//			->setFilter(['@APARTMENT_ID' => $allApartmens->getIdList()])
//			->setOrder(['APARTMENT.NUMBER' => 'DESC'])
//			->fetchObject();
		$apartment = ApartmentUserTable::getList([
			'select' => ['*', 'APARTMENT.NUMBER'],
			'filter' => ['@APARTMENT_ID' => $allApartmens->getIdList()],
			'order' => ['APARTMENT.NUMBER' => 'DESC']
		])->fetch();

		return $apartment['HC_HOUSECEEPER_MODEL_APARTMENT_USER_APARTMENT_NUMBER'];
	}

	public static function getHouseIdByApartmentId($apartmentId)
	{
		return ApartmentTable::query()
							 ->setSelect(['HOUSE_ID'])
							 ->setFilter(['ID' => $apartmentId])
							 ->fetch()['HOUSE_ID'];

	}

	public static function deleteApatments($houseId, $newApartmentsNumber, $oldApartmentsNumber)
	{
		$apartments = ApartmentTable::getList([
			'select' => ['*'],
			'filter' => [
				'HOUSE_ID' => $houseId,
				'><NUMBER' => [$newApartmentsNumber + 1, $oldApartmentsNumber]
			]
		])->fetchCollection();

		foreach ($apartments as $apartment)
		{
			$result = ApartmentTable::delete($apartment->getId());
		}
		return $result;
	}
}