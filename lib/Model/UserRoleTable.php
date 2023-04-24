<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Landing\Internals\RoleTable;
use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class UserRoleTable
 *
 * Fields:
 * <ul>
 * <li> USER_ID int mandatory
 * <li> ROLE_ID int mandatory
 * <li> HOUSE_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class UserRoleTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_user_role';
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
					'title' => Loc::getMessage('USER_ROLE_ENTITY_USER_ID_FIELD')
				]
			),
			new Reference(
				'USER',
				BUserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new IntegerField(
				'ROLE_ID',
				[
					'title' => Loc::getMessage('USER_ROLE_ENTITY_ROLE_ID_FIELD')
				]
			),
			new Reference(
				'ROLE',
				\Hc\Houseceeper\Model\RoleTable::class,
				Join::on('this.ROLE_ID', 'ref.ID')
			),
			new IntegerField(
				'HOUSE_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('USER_ROLE_ENTITY_HOUSE_ID_FIELD')
				]
			),
			new Reference(
				'HOUSE',
				HouseTable::class,
				Join::on('this.HOUSE_ID', 'ref.ID')
			),
		];
	}
}