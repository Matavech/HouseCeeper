<?php

class SignUpComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchError();
		$this->includeComponentTemplate();
	}

	public function fetchError()
	{
//		$this->arResult['ERRORS'] = $this->arParams['errors'];
//		$this->arResult['ERRORS'] = \Hc\Houseceeper\Errors::fetchErrors();
	}
}