<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class PostTypeTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(50) mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class PostTypeTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_post_type';
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
					'title' => Loc::getMessage('POST_TYPE_ENTITY_ID_FIELD')
				]
			),
			new Reference(
				'POST',
				PostTable::class,
				Join::on('this.ID', 'ref.TYPE_ID')
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('POST_TYPE_ENTITY_NAME_FIELD')
				]
			),

		];
	}

	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return [
			new LengthValidator(null, 50),
		];
	}
}