<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;

class User extends Controller
{
	public function getUserName ($id)
	{
		return \Hc\Houseceeper\Repository\User::getName($id);
	}

	public function deleteHeadman()
	{
		$request = Context::getCurrent()->getRequest();
		$userId = 	trim($request->getPost('headman-id'));
		$houseId = 	trim($request->getPost('house-id'));

		\Hc\Houseceeper\Repository\User::deleteHeadman($userId, $houseId);
	}

	public function addHeadman()
	{
		$request = Context::getCurrent()->getRequest();
		$userId = 	trim($request->getPost('user-id'));
		$houseId = 	trim($request->getPost('house-id'));

		\Hc\Houseceeper\Repository\User::addHeadman($userId, $houseId);
	}
}