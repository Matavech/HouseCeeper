<?php

class HouseListComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchHouseList();
		$this->includeComponentTemplate();
	}

	protected function fetchHouseList()
	{
		$houseList = new \Hc\Houseceeper\Controller\House();
		$list = $houseList->getListAction();
		$this->arResult['HOUSE'] = $list['houseList'];
		//$this->arResult['PAGE'] = $list['pageNumber'];
	}
}