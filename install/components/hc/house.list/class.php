<?php

class HouseListComponent extends CBitrixComponent {
	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->fetchHouseList();
		$this->includeComponentTemplate();
	}

	protected function fetchHouseList()
	{
		$houseList = new \Hc\Houseceeper\Controller\House();
		$list = $houseList->getListAction();
		if (count($list['houseList']) === 1)
		{
			LocalRedirect('/house/' . $list['houseList'][0]['UNIQUE_PATH']);
		}
		$this->arResult['HOUSE'] = $list['houseList'];
		//$this->arResult['PAGE'] = $list['pageNumber'];
	}
}