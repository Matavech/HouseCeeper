<?php

class SignInComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchError();
		$this->includeComponentTemplate();
	}
	public function fetchError()
	{
		$this->arResult['ERRORS'] = $this->arParams['errors'];
	}
}