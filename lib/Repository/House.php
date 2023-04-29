<?php

namespace Hc\Houseceeper\Repository;

use Bitrix\Main\ORM\Query\Query;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;

class House
{
	public static function getPage(int $itemsPerPage, int $pageNumber): array
	{
		if ($pageNumber > 1) {
			$offset = $itemsPerPage * ($pageNumber - 1);
		} else {
			$offset = 0;
		}
		global $USER;
		$accessedHouses = User::getUserHouses($USER->GetID());

		$query = HouseTable::query()
			->setSelect(['*']);
		if ($accessedHouses)
		{
			$query->setFilter(['ID' => $accessedHouses]);
			return $query->fetchAll();
		}
		return [];
	}

	public static function getDetails(string $houseId)
	{
		$query = HouseTable::query()
			->setSelect(['*'])
			->setFilter([
				'ID' => $houseId
			]);
		return $query->fetch();
	}

	public static function getRegisteredCount(string $houseId)
	{

	}

	public static function getIdByPath(string $housePath)
	{
		$query = HouseTable::query()
			->setSelect(['ID'])
			->setFilter([
				'UNIQUE_PATH' => $housePath
			]);

		$result = $query->fetch();

		if ($result) {
			return $result['ID'];
		}
		return false;
	}

	public static function getUserHousePath($userId)
	{
		$query = ApartmentUserTable::query()
			->setSelect(['APARTMENT_ID'])
			->setFilter(['USER_ID' => $userId]);

		$apartmentId = $query->fetch();

		$query = ApartmentTable::query()
			->setSelect(['HOUSE_ID'])
			->setFilter(['ID' => $apartmentId]);

		$houseId = $query->fetch();

		$query = HouseTable::query()
			->setSelect(['UNIQUE_PATH'])
			->setFilter(['ID' => $houseId]);

		$uniquePath = $query->fetch();

		return '/house/' . $uniquePath['UNIQUE_PATH'];
	}

	public static function  getUserApartmentNumber($userId, $housePath)
	{
		$query = HouseTable::query()
			->setSelect(['ID'])
			->setFilter(['UNIQUE_PATH' => $housePath]);
		$houseId = $query->fetch();

		$query = ApartmentUserTable::query()
		->setSelect(['apartment.NUMBER'])
		->setFilter([
			'USER_ID'=>$userId,
			'apartment.HOUSE_ID' => $houseId,
					]);

		$result = [];
		foreach ($query->fetchAll() as $item)
		{
			$result[] = (int)$item['HC_HOUSECEEPER_MODEL_APARTMENT_USER_APARTMENT_NUMBER'];
		}

		return $result;
	}

	public static function addHouse($houseName, $address, $numberOfApart, $uniquePath, $info)
	{
		$result = HouseTable::add([
				'NAME' => $houseName,
				'ADDRESS' => $address,
				'NUMBER_OF_APARTMENT' => $numberOfApart,
				'UNIQUE_PATH' => $uniquePath,
				'INFO' => $info
		]);
		return $result->getId();
	}

	public static function updateHouse($houseId, $houseName, $address, $numberOfApart, $uniquePath, $info)
	{
		return HouseTable::update($houseId, [
			'NAME' => $houseName,
			'ADDRESS' => $address,
			'NUMBER_OF_APARTMENT' => $numberOfApart,
			'UNIQUE_PATH' => $uniquePath,
			'INFO' => $info
		]);
	}

	public static function getPathById($houseId)
	{
		return HouseTable::query()
			->setSelect(['UNIQUE_PATH'])
			->setFilter(['ID'=>$houseId])
			->fetch()['UNIQUE_PATH'];

	}


}