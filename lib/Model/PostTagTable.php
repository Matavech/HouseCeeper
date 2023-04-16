<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

/**
 * Class PostTagTable
 *
 * Fields:
 * <ul>
 * <li> POST_ID int mandatory
 * <li> TAG_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class PostTagTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_post_tag';
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
					'title' => Loc::getMessage('POST_TAG_ENTITY_POST_ID_FIELD')
				]
			),
			new IntegerField(
				'TAG_ID',
				[
					'primary' => true,
					'title' => Loc::getMessage('POST_TAG_ENTITY_TAG_ID_FIELD')
				]
			),
			new Reference(
				'POST',
				PostTable::class,
				Join::on('this.POST_ID', 'ref.ID')
			),
			new Reference(
				'TAG',
				TagTable::class,
				Join::on('this.TAG_ID', 'ref.ID')
			),
		];
	}
}