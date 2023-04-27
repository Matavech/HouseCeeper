<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->arResult['HOUSE']['ID'] = \Hc\Houseceeper\Repository\House::getIdByPath($this->arParams['housePath']);
		$this->arResult['FILES'] = $this->prepareFileInput();
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
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
}