<?php

namespace Hc\Houseceeper\Repository;

use Hc\HouseCeeper\Constant\Role;
use Hc\Houseceeper\Model\ApartmentUserTable;
use Hc\Houseceeper\Model\UserRoleTable;
use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\RoleTable;
use Hc\Houseceeper\Model\HouseTable;

class User
{
	public static function getName($id)
	{
		if (self::isAdmin($id))
		{
			$result['NAME'] = 'Управляющая Компания';
			$result['LAST_NAME'] = '';
		}
		else
		{
			$query = BUserTable::query()->setSelect(['NAME', 'LAST_NAME'])->setFilter([
																						  'ID' => $id,
																					  ]);
			$result = $query->fetch();
		}
		if ($result)
		{
			return $result;
		}

		return false;
	}

	public static function getHouseHeadmenList($houseId)
	{
		$result = UserRoleTable::getList([
				'select' => ['USER_ID'],
				'filter' => [
					'=HOUSE_ID' => $houseId,
					'=ROLE.NAME' => Role::HC_HOUSECEEPER_ROLE_HEADMAN
				]
			]
		);
		$headmenIdList = [];
		foreach ($result->fetchAll() as $subarray) {
			$headmenIdList[] = $subarray["USER_ID"];
		}

		if($headmenIdList){
			$headmenList = BUserTable::getList([
				'select' => ['ID', 'NAME', 'LAST_NAME', 'EMAIL'],
				'filter' => ['=ID' => $headmenIdList]
			]);
			return $headmenList->fetchAll();
		}
	}

	public static function getHouseUserList($houseId)
	{
		$result = UserRoleTable::getList([
				'select' => ['USER_ID'],
				'filter' => [
					'=HOUSE_ID' => $houseId,
					'=ROLE.NAME' => Role::HC_HOUSECEEPER_ROLE_USER
				]
			]
		);
		$userIdList = [];
		foreach ($result->fetchAll() as $subarray) {
			$userIdList[] = $subarray["USER_ID"];
		}

		if($userIdList)
		{
			$userList = BUserTable::getList([
				'select' => ['ID', 'NAME', 'LAST_NAME', 'EMAIL'],
				'filter' => ['=ID' => $userIdList]
			]);
			return $userList->fetchAll();
		}
	}

	public static function deleteHeadman($userId, $houseId)
	{
		$roleId = RoleTable::getList([
			'select' => ['ID'],
			'filter' => ['=NAME' => Role::HC_HOUSECEEPER_ROLE_USER]
		])->fetch()['ID'];
		$newHeadman = UserRoleTable::getList([
			'select' => ['*'],
			'filter' => [
				'USER_ID' => $userId,
				'HOUSE_ID' =>$houseId
			]
		])->fetchObject();
		$newHeadman->setRoleId($roleId);
		$newHeadman->save();
	}

	public static function addHeadman($userId, $houseId)
	{
		$roleId = RoleTable::getList([
			'select' => ['ID'],
			'filter' => ['=NAME' => Role::HC_HOUSECEEPER_ROLE_HEADMAN]
		])->fetch()['ID'];
		$newHeadman = UserRoleTable::getList([
			'select' => ['*'],
			'filter' => [
				'USER_ID' => $userId,
				'HOUSE_ID' =>$houseId
				]
		])->fetchObject();
		$newHeadman->setRoleId($roleId);
		$newHeadman->save();
	}

	public static function isHeadman($userId, $houseId)
	{
		$result = UserRoleTable::query()
			->setSelect(['ROLE.NAME'])
			->setFilter(['USER_ID' => $userId, 'HOUSE_ID' => $houseId]);
		$role = $result->fetch()['HC_HOUSECEEPER_MODEL_USER_ROLE_ROLE_NAME'];

		return $role === Role::HC_HOUSECEEPER_ROLE_HEADMAN;
	}

	public static function isAdmin($userId)
	{
		$result = UserRoleTable::query()
							   ->setSelect(['ROLE.NAME'])
							   ->setFilter(['USER_ID' => $userId]);
		$role = $result->fetch()['HC_HOUSECEEPER_MODEL_USER_ROLE_ROLE_NAME'];

		return $role === Role::HC_HOUSECEEPER_ROLE_ADMIN;
	}

	public static function hasAccessToHouse($userId, $houseId)
	{
		if (self::isAdmin($userId))
		{
			return True;
		}

		$result = UserRoleTable::query()
			->setSelect(['ROLE_ID'])
			->setFilter([
				'USER_ID' => $userId,
				'HOUSE_ID' => $houseId,
						])
			->fetch();
		if ($result)
		{
			return True;
		}
		return False;
	}

	public static function getUserHouses($userId)
	{

		$allHouses = HouseTable::query()
			->setSelect(['ID'])
			->fetchAll();

		foreach ($allHouses as $house)
		{
			if (User::isAdmin($userId) || User::hasAccessToHouse($userId, $house['ID']))
			{
				$result[] = $house['ID'];
			}
		}
		return $result;
	}

	public static function removeUserFormHouse($userId, $houseId, $apartmentId)
	{
		$userRole = UserRoleTable::getList([
			'select' => ['*'],
			'filter' => [
				'USER_ID' => $userId,
				'HOUSE_ID' => $houseId
			]
		])->fetchObject()->delete();

		$apartmentUser = ApartmentUserTable::getList([
			'select' => ['*'],
			'filter' => [
				'USER_ID' => $userId,
				'APARTMENT_ID' => $apartmentId
			]
		])->fetchObject()->delete();
	}

	public static function setRole($userId, $houseId, $roleId)
	{
		$userRole = UserRoleTable::getList([
			'select' => ['*'],
			'filter' => [
				'HOUSE_ID' => $houseId,
				'USER_ID' => $userId
			]
		])->fetchObject();

		if($userRole){
			$userRole->set('ROLE_ID', $roleId);
			$userRole->save();
		} else {
			$result = UserRoleTable::add([
				'USER_ID' => $userId,
				'ROLE_ID' => $roleId,
				'HOUSE_ID' => $houseId,
			]);
			return $result;
		}
	}

	public static function registerUser($login, $name, $lastname, $password, $email)
	{
		global $USER;
		$resultMessage = $USER->Register($login, $name, $lastname, $password, $password, $email);
		if ($resultMessage['TYPE'] === 'OK') {
			$userId = $USER->GetID();
			$USER->Update($userId, [
				"WORK_COMPANY" => 'HouseCeeper'
			]);
			return $USER->GetID();
		}

		return $resultMessage['MESSAGE'];
	}
}