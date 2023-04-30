<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine\Controller;

class File extends Controller
{
	public static function deleteAvatar($userId)
	{
		$oldAvatarId = \Hc\Houseceeper\Repository\User::getUserAvatarId($userId);
		if ($oldAvatarId)
		{
			\Hc\Houseceeper\Repository\File::deleteFile($oldAvatarId);
			\Hc\Houseceeper\Repository\User::deleteAvatar($userId);
		}
	}

	public static function changeAvatar($userId, $file)
	{
		$arrFile = [
			"name" => $file["name"],
			"size" => $file["size"],
			"type" => $file["type"],
			"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $file["tmp_name"],
			"MODULE_ID" => "hc.houseceeper",
			"del" => "N"
		];
		$error = \CFile::CheckFile($arrFile,
								   10*1024*1024,
								   \Hc\Houseceeper\Repository\File::ACCEPTED_AVATAR_TYPES
		);
		if ($error)
		{
			return $error;
		}
		\CFile::ResizeImage(
			$arrFile,
			[
				'width' => 300,
				'height' => 300
			],
			'BX_RESIZE_IMAGE_EXACT'
		);

		$fileId = \Hc\Houseceeper\Repository\File::saveAvatar($userId, $arrFile);
		if ($fileId)
		{
			self::deleteAvatar($userId);
			\Hc\Houseceeper\Repository\User::setAvatar($userId, $fileId);
		}
	}
}