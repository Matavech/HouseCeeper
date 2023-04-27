<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Bitrix\Main\Context;
use Bitrix\Main\UI\PageNavigation;
use Hc\Houseceeper\Model\ApartmentTable;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\UserRoleTable;
use Hc\Houseceeper\Repository;

class House extends Engine\Controller
{
	protected const HOUSE_PER_PAGE = 20;
	protected const REG_KEY_LENGTH = 30;
	protected const APARTMENT_PER_PAGE = 10;

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
		if ($houseId) {
			$navObject = new PageNavigation('apartment_list');
			$navObject->allowAllRecords(false)
				->setPageSize(self::APARTMENT_PER_PAGE)
				->initFromUri();
			$houseDetails = Repository\House::getDetails($houseId);
			$houseHeadmanList = Repository\User::getHouseHeadmenList($houseId);
			$houseUserList = Repository\User::getHouseUserList($houseId);
			$apartment = new Apartment();
			$houseApartmentList = $apartment->getApartmentList($houseId, $navObject);
			//$registeredCount = Repository\House::getRegisteredCount($houseId);

			return [
				'houseDetails' => $houseDetails,
				'houseHeadmanList' => $houseHeadmanList,
				'houseUserList' => $houseUserList,
				'houseApartmentList' => $houseApartmentList,
				'navObject' => $navObject,
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

		$request = Context::getCurrent()->getRequest();
		$houseName = 				trim($request->getPost('house-name'));
		$uniquePath = 				trim($request->getPost('unique-path'));
		$numberOfApart = 			trim($request->getPost('number-of-apartments'));
		$address = 					trim($request->getPost('address'));
		$info = 					trim($request->getPost('info'));
		$headmanName = 				trim($request->getPost('headman-name'));
		$headmanLastname = 			trim($request->getPost('headman-lastname'));
		$headmanEmail =			 	trim($request->getPost('headman-email'));
		$headmanApartmentNumber = 	trim($request->getPost('headman-apartment-number'));
		$headmanLogin = 			trim($request->getPost('headman-login'));
		$headmanPassword = 			trim($request->getPost('headman-password'));

		if($headmanApartmentNumber > $numberOfApart){
			echo 'Номер квартиры председателя не должен превышать общее кол-во квартир';
			return;
		}

		try {
			\Bitrix\Main\Application::getConnection()->startTransaction();

			$result = HouseTable::add([
				'NAME' => $houseName,
				'ADDRESS' => $address,
				'NUMBER_OF_APARTMENT' => $numberOfApart,
				'UNIQUE_PATH' => $uniquePath,
				'INFO' => $info
			]);

			if ($result->isSuccess()) {
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

				if ((int) $headmanId > 0) {
					$result = UserRoleTable::add([
						'USER_ID' => $headmanId,
						'ROLE_ID' => 2,
						'HOUSE_ID' => $houseId
					]);

					if ($result->isSuccess()) {
//						$regKey = bin2hex(random_bytes(self::REG_KEY_LENGTH / 2));
//						$result = ApartmentTable::add([
//							'REG_KEY' => $regKey,
//							'NUMBER' => $headmanApartmentNumber,
//							'HOUSE_ID' => $houseId,
//						]);

						$apartmentList = [];
						for($i = 1; $i <= $numberOfApart; $i++){
							$apartmentList[] = [
								'NUMBER' => $i,
								'HOUSE_ID' => $houseId,
								'REG_KEY' => bin2hex(random_bytes(self::REG_KEY_LENGTH / 2))
							];
						}
						$result = ApartmentTable::addMulti($apartmentList);

						if ($result->isSuccess()) {
							$headmanApartment = ApartmentTable::getList([
								'select' => ['*'],
								'filter' => [
									'NUMBER' => $headmanApartmentNumber,
									'HOUSE_ID' => $houseId
								]
							])->fetchObject();

							ApartmentUserTable::add([
								'APARTMENT_ID' => $headmanApartment->getId(),
								'USER_ID' => $headmanId,
							]);

							\Bitrix\Main\Application::getConnection()->commitTransaction();

							LocalRedirect('/');
						}
					}
				} else {
					echo $headman->LAST_ERROR;
				}
			} else {
				$errors = $result->getErrors();
				foreach ($errors as $error) {
					echo $error->getMessage() . "</br>";
				}
			}

			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
		} catch (Exception $e) {
			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
			echo 'Произошла ошибка: ' . $e->getMessage();
		}
	}

	public function editHouse(){
		$request = Context::getCurrent()->getRequest();
		$houseId = 					trim($request->getPost('house-id'));
		$houseName = 				trim($request->getPost('house-name'));
		$uniquePath = 				trim($request->getPost('unique-path'));
		$numberOfApart = 			trim($request->getPost('number-of-apartments'));
		$address = 					trim($request->getPost('address'));
		$info = 					trim($request->getPost('info'));

		$result = HouseTable::update($houseId, [
			'NAME' => $houseName,
			'ADDRESS' => $address,
			'NUMBER_OF_APARTMENT' => $numberOfApart,
			'UNIQUE_PATH' => $uniquePath,
			'INFO' => $info
		]);

		if ($result->isSuccess())
		{
			LocalRedirect('/');
		}
		$errors = $result->getErrors();
		foreach ($errors as $error) {
			echo $error->getMessage() . "</br>";
		}
	}
}