<?php

class HouseDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchHouseDetailsList();
		$this->includeComponentTemplate();
	}

	public function fetchHouseDetailsList(){
		$detailsList = new \Hc\Houseceeper\Controller\House();
		$list = $detailsList->getDetailsAction($this->arParams['housePath']);
		$this->arResult['HOUSE'] = $list['houseDetails'];
		$this->arResult['REGISTEREDCOUNT'] = $list['registeredCount'];
	}
}