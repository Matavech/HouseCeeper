<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\HouseTable;

class Apartment extends Engine\Controller
{
		public function getApartmentList($houseId, $navObject)
		{
			$apartment = \Hc\Houseceeper\Repository\Apartment::getApartmentList($houseId, $navObject);
			$userList = $apartment['userList'];
			$apartmentList = $apartment['apartmentList'];

			$concatResult = [];

			foreach ($apartmentList as $apartment) {
				$apartmentId = $apartment['ID'];
				$concatResult[$apartmentId]['NUMBER'] = $apartment['NUMBER'];
				$concatResult[$apartmentId]['LINK'] = 'bitrix.dev.bx/sign-up?key=' . $apartment['REG_KEY'];
			}

			foreach ($userList as $user){
				$apartmentId = $user['APARTMENT_ID'];
				$concatResult[$apartmentId]['USERS'][] = [
					'FULL_NAME' => $user['HC_HOUSECEEPER_MODEL_APARTMENT_USER_USER_NAME'] . ' ' .
						$user['HC_HOUSECEEPER_MODEL_APARTMENT_USER_USER_LAST_NAME'],

					'ID' => $user['HC_HOUSECEEPER_MODEL_APARTMENT_USER_USER_ID']
				];
			}

			return $concatResult;
		}

}