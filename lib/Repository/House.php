<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;

class House
{
	public static function getPage(int $itemsPerPage, int $pageNumber): array
	{
		if ($pageNumber > 1)
		{
			$offset = $itemsPerPage * ($pageNumber - 1);
		}
		else
		{
			$offset = 0;
		}

		$houseList = HouseTable::getList()->fetchAll();

		return $houseList;
	}

	public static function redirectToHisHouse($userId) {
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

		LocalRedirect('/house/' . $uniquePath['UNIQUE_PATH']);
	}
}