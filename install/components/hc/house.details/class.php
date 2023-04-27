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
		foreach ($houseApartmentList as $id => $apartment) {
			$this->arResult['GRID_LIST'][] = [
				'data' => [
					"NUMBER" => $apartment['NUMBER'],
					"LINK" => $apartment['LINK'],
					"USERS" => ($apartment['USERS'] ? $this->prepareUserList($apartment['USERS'], $id) : '')
				]
			];
		}
	}

	public function prepareUserList($userList, $apartmentId)
	{
		global $APPLICATION;
		ob_start();
		$APPLICATION->IncludeComponent('hc:apartment.user.list', '', [
			'USER_LIST' => $userList,
			'HOUSE_ID' => $this->arResult['HOUSE']['ID'],
			'APARTMENT_ID' => $apartmentId
		]);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}