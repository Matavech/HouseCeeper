<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BUserTable;

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
}