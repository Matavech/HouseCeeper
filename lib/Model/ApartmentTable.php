<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\SocialServices\Integration\Zoom\Conference;

Loc::loadMessages(__FILE__);

/**
 * Class ApartmentTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NUMBER int mandatory
 * <li> REG_KEY string(50) mandatory
 * <li> HOUSE_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class ApartmentTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_apartment';
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
					'autocomplete' => true,
					'title' => Loc::getMessage('APARTMENT_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'NUMBER',
				[
					'required' => true,
					'title' => Loc::getMessage('APARTMENT_ENTITY_NUMBER_FIELD')
				]
			),
			new StringField(
				'REG_KEY',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateRegKey'],
					'title' => Loc::getMessage('APARTMENT_ENTITY_REG_KEY_FIELD')
				]
			),
			new IntegerField(
				'HOUSE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('APARTMENT_ENTITY_HOUSE_ID_FIELD')
				]
			),
			new Reference(
				'HOUSE',
				HouseTable::class,
				Join::on('this.HOUSE_ID', 'ref.ID')
			),
			new ManyToMany(
				'USER',
				UserTable::class
			),
		];
	}

	/**
	 * Returns validators for REG_KEY field.
	 *
	 * @return array
	 */
	public static function validateRegKey()
	{
		return [
			new LengthValidator(null, 50),
		];
	}
}