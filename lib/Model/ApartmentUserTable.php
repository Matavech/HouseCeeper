<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class ApartmentUserTable
 *
 * Fields:
 * <ul>
 * <li> USER_ID int mandatory
 * <li> APARTMENT_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class ApartmentUserTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_apartment_user';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'USER_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('APARTMENT_USER_ENTITY_USER_ID_FIELD')
				]
			),
			new IntegerField(
				'APARTMENT_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('APARTMENT_USER_ENTITY_APARTMENT_ID_FIELD')
				]
			),
			new Reference(
				'APARTMENT',
				ApartmentTable::class,
				Join::on('this.APARTMENT_ID', 'ref.ID')
			),
			new Reference(
				'USER',
				BUserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
		];
	}
}