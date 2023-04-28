<?php

class UserProfileComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
		$this->fetchHouses();
		$this->includeComponentTemplate();
	}

	protected function fetchUser()
	{
		global $USER;
		$this->arResult['USER'] = \Hc\Houseceeper\Controller\User::getUserGeneral($USER);
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
}