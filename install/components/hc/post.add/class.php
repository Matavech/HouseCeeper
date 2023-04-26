<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->arResult['HOUSE']['ID'] = \Hc\Houseceeper\Repository\House::getIdByPath($this->arParams['housePath']);
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->includeComponentTemplate();
	}
}