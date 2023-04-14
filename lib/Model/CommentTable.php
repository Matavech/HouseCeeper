<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\DatetimeField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator,
	Bitrix\Main\Type\DateTime;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class CommentTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> USER_ID int mandatory
 * <li> POST_ID int mandatory
 * <li> CONTENT string(200) mandatory
 * <li> DATETIME_CREATED datetime optional default current datetime
 * <li> PARENT_COMMENT_ID int optional
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class CommentTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_comment';
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
					'title' => Loc::getMessage('COMMENT_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'USER_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('COMMENT_ENTITY_USER_ID_FIELD')
				]
			),
			new Reference(
				'USER',
				\Bitrix\Main\UserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new IntegerField(
				'POST_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('COMMENT_ENTITY_POST_ID_FIELD')
				]
			),
			new Reference(
				'POST',
				PostTable::class,
				Join::on('this.POST_ID', 'ref.ID')
			),
			new StringField(
				'CONTENT',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateContent'],
					'title' => Loc::getMessage('COMMENT_ENTITY_CONTENT_FIELD')
				]
			),
			new DatetimeField(
				'DATETIME_CREATED',
				[
					'default' => function()
					{
						return new DateTime();
					},
					'title' => Loc::getMessage('COMMENT_ENTITY_DATETIME_CREATED_FIELD')
				]
			),
			new IntegerField(
				'PARENT_COMMENT_ID',
				[
					'title' => Loc::getMessage('COMMENT_ENTITY_PARENT_COMMENT_ID_FIELD')
				]
			),
			new Reference(
				'PARRENT_COMMENT',
				__CLASS__,
				Join::on('this.PARENT_COMMENT_ID', 'ref.ID')
			),
		];
	}

	/**
	 * Returns validators for CONTENT field.
	 *
	 * @return array
	 */
	public static function validateContent()
	{
		return [
			new LengthValidator(null, 200),
		];
	}
}