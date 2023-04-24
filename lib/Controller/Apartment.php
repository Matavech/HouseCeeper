<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\HouseTable;

class Apartment extends Engine\Controller
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

		return $query->fetch();
	}
}