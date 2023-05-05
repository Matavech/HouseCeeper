<?php

class UserProfileComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchError();
		$this->fetchUser();
		$this->fetchHouses();
		$this->arResult['FILES'] = $this->prepareFileInput();
		$this->includeComponentTemplate();
	}

	protected function fetchUser()
	{
		global $USER;
		$this->arResult['USER'] = \Hc\Houseceeper\Controller\User::getUserGeneral($USER);
		$this->arResult['USER']['AVATAR'] = \Hc\Houseceeper\Controller\User::getUserAvatar($USER->GetID());

	}
	protected function fetchHouses()
	{
		$house = new \Hc\Houseceeper\Controller\House();
		$houses = $house->getListAction()['houseList'];
		foreach ($houses as $key => $house)
		{
			$apartments =  \Hc\Houseceeper\Repository\House::getUserApartmentNumber($this->arResult['USER']['ID'], $house['UNIQUE_PATH']);
			foreach ($apartments as $apartment)
			{
				$houses[$key]['APARTMENTS'][$apartment] =  \Hc\Houseceeper\Repository\Apartment::getApartmentIdFromNumber($apartment, $house['ID']);
			}
		}
		$this->arResult['HOUSES'] = $houses;
	}

	protected function prepareFileInput()
	{
		return \Bitrix\Main\UI\FileInput::createInstance(
			[
				"name" => "files[#IND#]",
				"description" => true,
				"upload" => true,
				"allowUpload" => "A",
				"medialib" => true,
				"fileDialog" => true,
				"delete" => true,
				"maxCount" => 1,
				"maxSize" => 10*1024*1024
			]);
	}
	public function fetchError()
	{
//		$this->arResult['ERRORS'] = $this->arParams['errors'];
		$errors = \Bitrix\Main\Application::getInstance()->getSession()->get('errors');
		if ($errors)
		{
			foreach ($errors as $error)
			{
				$this->arResult['ERRORS'][] = '<div class="error">' . htmlspecialcharsbx($error) . '</div>';
			}
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', []);
		}
	}
}