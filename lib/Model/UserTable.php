<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class UserTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> ROLE_ID int mandatory
 * <li> IMAGE_PATH string(100) optional
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class UserTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_user';
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
				'ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('USER_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'ROLE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('USER_ENTITY_ROLE_ID_FIELD')
				]
			),
			new Reference(
				'ROLE',
				RoleTable::class,
				Join::on('this.ROLE_ID', 'ref.ID')
			),
			new StringField(
				'IMAGE_PATH',
				[
					'validation' => [__CLASS__, 'validateImagePath'],
					'title' => Loc::getMessage('USER_ENTITY_IMAGE_PATH_FIELD')
				]
			),
			new ManyToMany(
				'APARTMENT',
				ApartmentTable::class
			),
			new OneToMany(
				'COMMENTS',
				CommentTable::class,
				'USER'
			),
			new OneToMany(
				'POSTS',
				PostTable::class,
				'USER'
			),
		];
	}

	/**
	 * Returns validators for IMAGE_PATH field.
	 *
	 * @return array
	 */
	public static function validateImagePath()
	{
		return [
			new LengthValidator(null, 100),
		];
	}
}