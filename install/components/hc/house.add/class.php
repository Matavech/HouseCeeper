<?php

class HouseAddComponent extends CBitrixComponent {
	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->includeComponentTemplate();
	}
}