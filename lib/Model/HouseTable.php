<?php
namespace Hc\Houseceeper\Model;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Validators\EnumValidator;
use Bitrix\Main\ORM\Fields\Validators\RangeValidator;
use Bitrix\Main\ORM\Fields\Validators\RegExpValidator;
use Bitrix\Main\ORM\Fields\Validators\UniqueValidator;
use Bitrix\Main\PhoneNumber\Tools\RegexField;

Loc::loadMessages(__FILE__);

/**
 * Class HouseTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(50) mandatory
 * <li> ADDRESS string(100) optional
 * <li> NUMBER_OF_APARTMENT int mandatory
 * <li> UNIQUE_PATH string(50) mandatory
 * </ul>
 *
 * @package Bitrix\Houseceeper
 **/

class HouseTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'hc_houseceeper_house';
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
					'title' => Loc::getMessage('HOUSE_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'NAME',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateName'],
					'title' => Loc::getMessage('HOUSE_ENTITY_NAME_FIELD')
				]
			),
			new StringField(
				'ADDRESS',
				[
					'validation' => [__CLASS__, 'validateAddress'],
					'title' => Loc::getMessage('HOUSE_ENTITY_ADDRESS_FIELD')
				]
			),
			new IntegerField(
				'NUMBER_OF_APARTMENT',
				[
					'required' => true,
					'title' => Loc::getMessage('HOUSE_ENTITY_NUMBER_OF_APARTMENT_FIELD'),
					'validation' => [__CLASS__, 'validateNumberOfApartment']
				]
			),
			new StringField(
				'UNIQUE_PATH',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateUniquePath'],
					'title' => Loc::getMessage('HOUSE_ENTITY_UNIQUE_PATH_FIELD')
				]
			),
			new OneToMany(
				'APARTMENTS',
				ApartmentTable::class,
				'HOUSE'
			),
			new OneToMany(
				'POSTS',
				PostTable::class,
				'HOUSE'
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
			new LengthValidator(1, 50),
		];
	}

	/**
	 * Returns validators for ADDRESS field.
	 *
	 * @return array
	 */
	public static function validateAddress()
	{
		return [
			new LengthValidator(1, 100),
		];
	}
	/**
	 * Returns validators for NUMBER_OF_APARTMENT field.
	 *
	 * @return array
	 */
	public static function validateNumberOfApartment()
	{
		return [
			//new EnumValidator(),
			new RangeValidator(1)
		];
	}

	/**
	 * Returns validators for UNIQUE_PATH field.
	 *
	 * @return array
	 */
	public static function validateUniquePath()
	{
		return [
			new LengthValidator(1, 50),
			new RegExpValidator('/^[a-z0-9+-]*$/'),
			new UniqueValidator()
		];
	}
}