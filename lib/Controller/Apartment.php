<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Hc\Houseceeper\Model\ApartmentTable;

class Apartment extends Engine\Controller
{
	public static function generateRegKey($houseId, $apartNumber) {
		return md5($houseId . '+' . $apartNumber);
	}

	public static function checkRegKey($key) {

	}
}