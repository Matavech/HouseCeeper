<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\UserRoleTable;
use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\RoleTable;

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
					'=ROLE.NAME' => 'headman'
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
					'=ROLE.NAME' => 'user'
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
			'filter' => ['=NAME' => 'user']
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

		LocalRedirect('about');
	}

	public static function addHeadman($userId, $houseId)
	{
		$roleId = RoleTable::getList([
			'select' => ['ID'],
			'filter' => ['=NAME' => 'headman']
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

		LocalRedirect('about');
	}

	public static function isHeadman($userId, $houseId)
	{
		$result = UserRoleTable::query()
			->setSelect(['ROLE.NAME'])
			->setFilter(['USER_ID' => $userId, 'HOUSE_ID' => $houseId]);
		$role = $result->fetch()['HC_HOUSECEEPER_MODEL_USER_ROLE_ROLE_NAME'];
		
		return $role === 'headman';
	}

	public static function isAdmin($userId)
	{
		$result = UserRoleTable::query()
							   ->setSelect(['ROLE.NAME'])
							   ->setFilter(['USER_ID' => $userId]);
		$role = $result->fetch()['HC_HOUSECEEPER_MODEL_USER_ROLE_ROLE_NAME'];

		return $role === 'admin';
	}
}