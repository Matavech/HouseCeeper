<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Validators\RegExpValidator;
use Bitrix\Main\ORM\Fields\Validators\UniqueValidator;

Loc::loadMessages(__FILE__);

/**
 * Class PostFileTable
 *
 * Fields:
 * <ul>
 * <li> POST_ID int mandatory
 * <li> FILE_PATH string(50) mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class PostFileTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_post_file';
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
				'POST_ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('POST_FILE_ENTITY_POST_ID_FIELD')
				]
			),
			new Reference(
				'POST',
				PostTable::class,
				Join::on('this.POST_ID', 'ref.ID')
			),
			new StringField(
				'FILE_PATH',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateFilePath'],
					'title' => Loc::getMessage('POST_FILE_ENTITY_FILE_PATH_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for FILE_PATH field.
	 *
	 * @return array
	 */
	public static function validateFilePath()
	{
		return [
			new RegExpValidator('/^[a-z0-9+-]*$/'),
			new LengthValidator(null, 50),
			new UniqueValidator()
		];
	}
}