<?php

class SignInComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchError();
		$this->includeComponentTemplate();
	}

	public function fetchError()
	{
		$this->arResult['ERROR'] = $this->arParams['error'];
	}
}