<?php

class ApartmentUserListComponent extends CBitrixComponent {
	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		//$this->prepareComponentParams();
		$this->includeComponentTemplate();
	}
}