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
			$errors[] = 'Номер квартиры председателя не должен превышать общее кол-во квартир';
		}

		try {
			\Bitrix\Main\Application::getConnection()->startTransaction();

			$houseId = Repository\House::addHouse($houseName, $address, $numberOfApart, $uniquePath, $info);

			Repository\Apartment::addApartments($houseId, 1, $numberOfApart);

			if($houseId){
				$result = Repository\User::registerUser($headmanLogin, $headmanName, $headmanLastname, $headmanPassword, $headmanEmail);

				if(is_numeric($result)){
					$headmanId = $result;
					Repository\User::setRole($headmanId, $houseId, 2);
					$apartmentId = Repository\Apartment::getApartmentIdFromNumber($headmanApartmentNumber, $houseId);

					if($apartmentId){
						Repository\Apartment::addUser($apartmentId, $headmanId);

						\Bitrix\Main\Application::getConnection()->commitTransaction();
						LocalRedirect('/');
					}
				}
				else
				{
					foreach (explode('<br>', $result) as $error)
					{
						if ($error)
						{
							$errors[] = $error;
						}
					}
				}
			}

			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
		} catch (Exception $e) {
			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
			$errors[] =  $e->getMessage();
		}
		if ($errors) {
			$APPLICATION = new \CMain();
			$APPLICATION->IncludeComponent('hc:house.add', '', [
				'errors' => $errors,
			]);
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

		if (Repository\Apartment::getMaxApartmentNumber($houseId) < $numberOfApart){
			echo 'Новое количество квартир не должно быть меньшее чем максимальный номер существующей квартиры';
			return;
		}

		$result = Repository\House::updateHouse($houseId, $houseName, $address, $numberOfApart, $uniquePath, $info);

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