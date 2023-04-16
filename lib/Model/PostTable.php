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
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class PostTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> HOUSE_ID int mandatory
 * <li> USER_ID int optional
 * <li> TITLE string(100) mandatory
 * <li> CONTENT string(1000) optional
 * <li> DATETIME_CREATED datetime optional default current datetime
 * <li> TYPE_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class PostTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_post';
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
					'title' => Loc::getMessage('POST_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'HOUSE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('POST_ENTITY_HOUSE_ID_FIELD')
				]
			),
			new Reference(
				'HOUSE',
				HouseTable::class,
				Join::on('this.HOUSE_ID', 'ref.ID')
			),
			new IntegerField(
				'USER_ID',
				[
					'title' => Loc::getMessage('POST_ENTITY_USER_ID_FIELD')
				]
			),
			new Reference(
				'USER',
				UserTable::class,
				Join::on('this.USER_ID', 'ref.ID')
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateTitle'],
					'title' => Loc::getMessage('POST_ENTITY_TITLE_FIELD')
				]
			),
			new StringField(
				'CONTENT',
				[
					'validation' => [__CLASS__, 'validateContent'],
					'title' => Loc::getMessage('POST_ENTITY_CONTENT_FIELD')
				]
			),
			new DatetimeField(
				'DATETIME_CREATED',
				[
					'default' => function()
					{
						return new DateTime();
					},
					'title' => Loc::getMessage('POST_ENTITY_DATETIME_CREATED_FIELD')
				]
			),
			new IntegerField(
				'TYPE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('POST_ENTITY_TYPE_ID_FIELD')
				]
			),
			new Reference(
				'TYPE',
				PostTypeTable::class,
				Join::on('this.TYPE_ID', 'ref.ID')
			),
			new OneToMany(
				'COMMENTS',
				CommentTable::class,
				'POST'
			),
			new OneToMany(
				'FILES',
				PostFileTable::class,
				'POST'
			),
			(new ManyToMany(
				'TAGS',
				TagTable::class
			))->configureTableName('hc_houseceeper_post_tag'),
		];
	}

	/**
	 * Returns validators for TITLE field.
	 *
	 * @return array
	 */
	public static function validateTitle()
	{
		return [
			new LengthValidator(null, 100),
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
			new LengthValidator(null, 1000),
		];
	}
}