<?php

class CommentComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->prepareComponentParams();
		$this->includeComponentTemplate();
	}

	protected function prepareComponentParams()
	{
		global $USER;
		$this->arParams['COMMENT']['DATETIME_CREATED'] = FormatDate([ 's' => 'sago',
																	  'i' => 'iago',
																	  'H' => 'Hago',
																	  '' => 'dago',], $this->arParams['COMMENT']['DATETIME_CREATED']);
		$apartments = \Hc\Houseceeper\Repository\House::getUserApartmentNumber($USER->GetID(), $_REQUEST['housePath']);
		$loc = count($apartments)>1 ? 'HC_HOUSECEEPER_COMMENT_APARTMENTS' : 'HC_HOUSECEEPER_COMMENT_APARTMENT';
		$this->arParams['COMMENT']['USER_APARTMENT_NUMBER'] = \Bitrix\Main\Localization\Loc::getMessage($loc);
		$this->arParams['COMMENT']['USER_APARTMENT'] = implode(', ', $apartments);
	}
}