<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\HouseTable;

class Apartment extends Engine\Controller
{
	protected const REG_KEY_LENGTH = 50;
	public static function generateRegKey($houseId, $apartNumber)
	{
		// Checking rights
		// W.I.P.

		$query = HouseTable::getById($houseId);
		$house = $query->fetch();
		if ($house) {
			$exitLink = '/house-about/' . $house['UNIQUE_PATH'];

			if (!is_numeric($apartNumber) || $apartNumber < 1 || $apartNumber > $house['NUMBER_OF_APARTMENT'])
				LocalRedirect($exitLink);

			$apartment = ApartmentTable::getList([
				'select' => ['REG_KEY'],
				'filter' => [
					'HOUSE_ID' => $houseId,
					'NUMBER' => $apartNumber
				]
			])->fetchObject();

			if (!$apartment) {
				$newRegKey = bin2hex(random_bytes(self::REG_KEY_LENGTH));
				$result = ApartmentTable::add([
					'HOUSE_ID' => $houseId,
					'NUMBER' => $apartNumber,
					'REG_KEY' => $newRegKey,
				]);

				if ($result->isSuccess()) {
					echo 'Квартира была добавленна' . '</br>';
					return $newRegKey;
				}
			}
			return $apartment->get('REG_KEY');
		}
		return 'Дом не найден';
	}
}