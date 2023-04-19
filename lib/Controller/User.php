<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine\Controller;

class User extends Controller
{
	public function getUserName ($id)
	{
		return \Hc\Houseceeper\Repository\User::getName($id);
	}
}