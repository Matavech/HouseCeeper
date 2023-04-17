<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\UserTable;
use Hc\Houseceeper\Repository;

class House extends Engine\Controller
{
	protected const HOUSE_PER_PAGE = 20;

	public function getListAction(int $pageNumber = 1): ?array
	{
		if ($pageNumber < 0) {
			$this->addError(new Error('pageNumber should be greater than 0', 'invalid_page_number'));

			return null;
		}

		$houseList = Repository\House::getPage(self::HOUSE_PER_PAGE, $pageNumber);

		return [
			'pageNumber' => $pageNumber,
			'houseList' => $houseList,
		];
	}

	public function getDetailsAction(string $housePath)
	{
		$houseId = Repository\House::getIdByPath($housePath);
		if ($houseId)
		{
			$houseDetails = Repository\House::getDetails($houseId);
			//$registeredCount = Repository\House::getRegisteredCount($houseId);

		return [
			'houseDetails' => $houseDetails,
			//'registeredCount' => $registeredCount,
		];
		}
		LocalRedirect('/');
	}

	public function addNewHouse()
	{
//		if (!check_bitrix_sessid()) {
//			LocalRedirect('/');
//		}

		$houseName = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('house-name'));
		$uniquePath = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('unique-path'));
		$numberOfApart = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('number-of-apartments'));
		$address = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('address'));
		$info = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('info'));
		$headmanName = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-name'));
		$headmanLastname = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-lastname'));
		$headmanEmail = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-email'));
		$headmanApartmentNumber = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-apartment-number'));
		$headmanLogin = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-login'));
		$headmanPassword = trim(\Bitrix\Main\Context::getCurrent()->getRequest()->getPost('headman-password'));

		$result = HouseTable::add([
			'NAME' => $houseName,
			'ADDRESS' => $address,
			'NUMBER_OF_APARTMENT' => $numberOfApart,
			'UNIQUE_PATH' => $uniquePath,
			'INFO' => $info
		]);

		if ($result->isSuccess()) {
			//var_dump('house add success');
			$houseId = $result->getId();
			$headman = new \CUser();
			$headmanId = $headman->Add([
				'NAME' => $headmanName,
				'LAST_NAME' => $headmanLastname,
				'EMAIL' => $headmanEmail,
				'LOGIN' => $headmanLogin,
				'PASSWORD' => $headmanPassword,
				'WORK_COMPANY' => 'HouseCeeper',
			]);

			if ((int)$headmanId > 0) {
				//var_dump('headmen profile add success');
				$result = UserTable::add([
					'ID' => $headmanId,
					'ROLE_ID' => 2
				]);

				if ($result->isSuccess()) {
					//var_dump('headmen add success');
					//$regKey = Apartment::generateRegKey($houseId, $headmanApartmentNumber);
					$result = ApartmentTable::add([
						//'REG_KEY' => $regKey,
						'NUMBER' => $headmanApartmentNumber,
						'HOUSE_ID' => $houseId,
					]);

					if ($result->isSuccess()) {
						//var_dump('apartment add success');
						$apartId = $result->getId();
						ApartmentUserTable::add([
							'APARTMENT_ID' => $apartId,
							'USER_ID' => $headmanId,
						]);

						LocalRedirect('/');
					}
				}
			} else {
				echo $headman->LAST_ERROR;
			}
		}
		$errors = $result->getErrors();
		foreach ($errors as $error)
		{
			echo $error->getMessage() . "</br>";
		}
	}
}