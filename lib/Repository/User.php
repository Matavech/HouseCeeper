<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\RoleTable;
use Hc\Houseceeper\Model\UserTable;

class User
{
	public static function getName($id)
	{
		$query = BUserTable::query()
						   ->setSelect(['NAME', 'LAST_NAME'])
						   ->setFilter([
								  'ID' => $id,
								  ]);
		$result = $query->fetch();

		if ($result)
		{
			return $result;
		}

		return false;
	}

	public static function getHouseHeadmenList($houseId)
	{
		$result = UserTable::getList([
				'select' => ['ID'],
				'filter' => [
					'=APARTMENT.HOUSE_ID' => $houseId,
					'=ROLE.NAME' => 'headman'
				]
			]
		);
		$headmenIdList = [];
		foreach ($result->fetchAll() as $subarray) {
			$headmenIdList[] = $subarray["ID"];
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
		$result = UserTable::getList([
				'select' => ['ID'],
				'filter' => [
					'=APARTMENT.HOUSE_ID' => $houseId,
					'=ROLE.NAME' => 'user'
				]
			]
		);
		$userIdList = [];
		foreach ($result->fetchAll() as $subarray) {
			$userIdList[] = $subarray["ID"];
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

	public static function deleteHeadman($userId)
	{
		$roleId = RoleTable::getList([
			'select' => ['ID'],
			'filter' => ['=NAME' => 'user']
		])->fetch()['ID'];
		$result = UserTable::update($userId, [
			'ROLE_ID' => $roleId
		]);
		if ($result->isSuccess())
		{
			LocalRedirect('about');
		}
		$errors = $result->getErrors();
		foreach ($errors as $error) {
			echo $error->getMessage() . "</br>";
		}
	}

	public static function addHeadman($userId)
	{
		$roleId = RoleTable::getList([
			'select' => ['ID'],
			'filter' => ['=NAME' => 'headman']
		])->fetch()['ID'];
		$result = UserTable::update($userId, [
			'ROLE_ID' => $roleId
		]);
		if ($result->isSuccess())
		{
			LocalRedirect('about');
		}
		$errors = $result->getErrors();
		foreach ($errors as $error) {
			echo $error->getMessage() . "</br>";
		}
	}

	public static function isHeadman($userId)
	{

		$result = UserTable::query()
			->setSelect(['role.NAME'])
			->setFilter(['ID' => $userId]);
		$role = $result->fetch()['HC_HOUSECEEPER_MODEL_USER_ROLE_NAME'];
		
		if ($role === 'headman') return True;
	}


}