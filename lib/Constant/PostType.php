<?php

namespace Hc\HouseCeeper\Constant;

use Bitrix\Main\Engine\Controller;

class PostType extends Controller
{
	public const HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT = 'announcement';
	public const HC_HOUSECEEPER_POSTTYPE_DISCUSSION = 'discussion';
	public const HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED = 'unconfirmed';

	public static function getTypesInJsonAction()
	{
		return
			[	'HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT' => self::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT,
								'HC_HOUSECEEPER_POSTTYPE_DISCUSSION' => self::HC_HOUSECEEPER_POSTTYPE_DISCUSSION,
								'HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED' => self::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED,
							   ];
	}
}