<?php

namespace Hc\HouseCeeper\Constant;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Localization\Loc;

class PostType extends Controller
{
	public const HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT = 'announcement';
	public const HC_HOUSECEEPER_POSTTYPE_DISCUSSION = 'discussion';
	public const HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED = 'unconfirmed';

	public const HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT_RU_LANG = 'Объявление';
	public const HC_HOUSECEEPER_POSTTYPE_DISCUSSION_RU_LANG = 'Обсуждение';
	public const HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED_RU_LANG = 'Неподтвержден';


	public static function getTypesAction()
	{
		return
			[
				'HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT' => self::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT,
				'HC_HOUSECEEPER_POSTTYPE_DISCUSSION' => self::HC_HOUSECEEPER_POSTTYPE_DISCUSSION,
				'HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED' => self::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED,
		    ];
	}

	public static function getTypesRuLangAction()
	{
		return
			[	'HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT_RU' => self::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT_RU_LANG,
				 'HC_HOUSECEEPER_POSTTYPE_DISCUSSION_RU' => self::HC_HOUSECEEPER_POSTTYPE_DISCUSSION_RU_LANG,
				 'HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED_RU' => self::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED_RU_LANG,
			];
	}
}