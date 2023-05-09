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
																	  '' => 'dago',],
																	$this->arParams['COMMENT']['DATETIME_CREATED']);
		$apartments = \Hc\Houseceeper\Repository\House::getUserApartmentNumber($this->arParams['COMMENT']['USER_ID'], $_REQUEST['housePath']);

		$user = CUser::GetByID($this->arParams['COMMENT']['USER_ID'])->GetNext();
		$personalPhoto = $user['PERSONAL_PHOTO'];
		if($personalPhoto) {
			$this->arParams['COMMENT']['USER_AVATAR'] = CFile::ResizeImageGet(
				$personalPhoto,
				['width'=>128, 'height'=>128],
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			)['src'];
		} else {
			$this->arParams['COMMENT']['USER_AVATAR'] = "/local/modules/hc.houseceeper/install/files/user-avatars/default-avatar.png";
		}

		$loc = count($apartments)>1 ? 'HC_HOUSECEEPER_COMMENT_APARTMENTS' : 'HC_HOUSECEEPER_COMMENT_APARTMENT';
		$this->arParams['COMMENT']['USER_APARTMENT_NUMBER'] = \Bitrix\Main\Localization\Loc::getMessage($loc);
		$this->arParams['COMMENT']['USER_APARTMENT'] = implode(', ', $apartments);
	}
}