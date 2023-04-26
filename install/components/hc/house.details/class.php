<?php

class HouseDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->fetchHouseDetailsList();

		$this->includeComponentTemplate();
	}

	public function fetchHouseDetailsList(){
		$detailsList = new \Hc\Houseceeper\Controller\House();
		$list = $detailsList->getDetailsAction($this->arParams['housePath']);
		$this->arResult['HOUSE'] = $list['houseDetails'];
		$this->arResult['HEADMEN_LIST'] = $list['houseHeadmanList'];
		$this->arResult['USER_LIST'] = $list['houseUserList'];
		$this->arResult['NAV_OBJECT'] = $list['navObject'];

		$this->prepareGridList($list['houseApartmentList']);
		//$this->arResult['REGISTEREDCOUNT'] = $list['registeredCount'];
	}

	public function prepareGridList($houseApartmentList){
		$this->arResult['GRID_LIST'] = [];
		foreach ($houseApartmentList as $apartment) {
			$this->arResult['GRID_LIST'][] = [
				'data' => [ //Данные ячеек
					"NUMBER" => $apartment['NUMBER'],
					"LINK" => $apartment['LINK'],
					"USERS" => implode(', ', $apartment['USERS'])
				],
				'actions' => [ //Действия над ними

				],
			];
		}
	}
}