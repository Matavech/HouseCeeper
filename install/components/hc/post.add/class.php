<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchError();
		$this->arResult['HOUSE']['ID'] = \Hc\Houseceeper\Repository\House::getIdByPath($this->arParams['housePath']);
		$this->arResult['FILES'] = $this->prepareFileInput();
		$this->includeComponentTemplate();
	}

	protected function prepareFileInput()
	{
		return \Bitrix\Main\UI\FileInput::createInstance(
			[
			  "name" => "files[#IND#]",
			  "description" => true,
			  "upload" => true,
			  "allowUpload" => "A",
			  "medialib" => true,
			  "fileDialog" => true,
			  "delete" => true,
			  "maxCount" => 10,
			  "maxSize" => 50*1024*1024
			]);
	}

	public function fetchError()
	{
//		$this->arResult['ERRORS'] = $this->arParams['errors'];
		$errors = \Bitrix\Main\Application::getInstance()->getSession()->get('errors');
		if ($errors)
		{
			foreach ($errors as $error)
			{
				$this->arResult['ERRORS'][] = '<div class="error">' . htmlspecialcharsbx($error) . '</div>';
			}
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', []);
		}
	}
}