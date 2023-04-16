<?php

class SignUpComponent extends CBitrixComponent {
	public function executeComponent()
	{

		\Bitrix\Main\Loader::includeModule('hc.houseceeper');
		$this->includeComponentTemplate();
	}
}