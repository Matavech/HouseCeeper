<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine\Controller;

class File extends Controller
{
	public static function deleteAvatarAction()
	{
		global $USER;
		$userId = $USER->GetID();
		$oldAvatarId = \Hc\Houseceeper\Repository\User::getUserAvatarId($userId);
		if ($oldAvatarId)
		{
			\Hc\Houseceeper\Repository\File::deleteFile($oldAvatarId);
			\Hc\Houseceeper\Repository\User::deleteAvatar($userId);
		}
		LocalRedirect('/profile');
	}

	public static function changeAvatarAction($files)
	{
		$photo = $files[0];
		if (!$photo)
		{
			LocalRedirect('/profile');
		}
		$arrFile = [
			"name" => $photo["name"],
			"size" => $photo["size"],
			"type" => $photo["type"],
			"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $photo["tmp_name"],
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
		global $USER;
		$userId = $USER->GetId();

		$fileId = \Hc\Houseceeper\Repository\File::saveAvatar($userId, $arrFile);
		if ($fileId)
		{
			$oldAvatarId = \Hc\Houseceeper\Repository\User::getUserAvatarId($userId);
			if ($oldAvatarId)
			{
				\Hc\Houseceeper\Repository\File::deleteFile($oldAvatarId);
				\Hc\Houseceeper\Repository\User::deleteAvatar($userId);
			}
			\Hc\Houseceeper\Repository\User::setAvatar($userId, $fileId);
		}
		LocalRedirect('/profile');
	}
}