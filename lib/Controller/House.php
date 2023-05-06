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

	public function addNewHouseAction($houseName, $uniquePath, $numberOfApart, $address, $info, $headmanName, $headmanLastname, $headmanEmail, $headmanApartmentNumber, $headmanLogin, $headmanPassword)
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

			$result = Repository\House::addHouse($houseName, $address, $numberOfApart, $uniquePath, $info);

			if(is_numeric($result)){
				$houseId = $result;
				Repository\Apartment::addApartments($houseId, 1, $numberOfApart);

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
			}
			foreach ($result as $error)
			{
				if ($error)
				{
					$errors[] = $error;
				}
			}

			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
		} catch (Exception $e) {
			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
			$errors[] =  $e->getMessage();
		}
		if ($errors) {
//			$APPLICATION = new \CMain();
//			$APPLICATION->IncludeComponent('hc:house.add', '', [
//				'errors' => $errors,
//			]);
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/add-house');
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

		$errors = [];
		try {
			\Bitrix\Main\Application::getConnection()->startTransaction();

			if (Repository\Apartment::getMaxApartmentNumber($houseId) > (int)$numberOfApart){
				$errors[] = 'Новое количество квартир не должно быть меньше, чем максимальный номер заселенной квартиры';
			} else {
				$oldApartmentsNumber = \Hc\Houseceeper\Repository\House::getNumberOfApartment($houseId);
				if ($oldApartmentsNumber > $numberOfApart){
					$result = Repository\Apartment::deleteApatments($houseId, $numberOfApart, $oldApartmentsNumber);
				} elseif ($oldApartmentsNumber < $numberOfApart) {
					$result = Repository\Apartment::addApartments($houseId, $oldApartmentsNumber + 1, $numberOfApart);
				} else {
					$result = true;
				}

				if ($result || $result->isSuccess()){
					$result = Repository\House::updateHouse($houseId, $houseName, $address, $numberOfApart, $uniquePath, $info);
					if ($result->isSuccess())
					{
						\Bitrix\Main\Application::getConnection()->commitTransaction();
					} else {
						foreach ($result->getErrors() as $error) {
							$errors[] = $error->getMessage();
						}
					}
				} else {
					foreach ($result->getErrors() as $error) {
						$errors[] = $error->getMessage();
					}
				}
			}

			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
		} catch (Exception $e) {
			\Bitrix\Main\Application::getConnection()->rollbackTransaction();
			$errors[] =  $e->getMessage();
		}

		if ($errors) {
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		}
		LocalRedirect('about');
	}
}