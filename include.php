<?php

use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;
use Bitrix\Main\Request;
Bitrix\Main\Loader::includeModule('hc.houseceeper');
function request(): Request
{
	return Application::getInstance()->getContext()->getRequest();
}

function db(): Connection
{
	return Application::getConnection();
}

function extractValueFromLink($link) {
	$pattern = '/^\/house\/([a-z0-9-]+)(?:\/|$)/';
	if (preg_match($pattern, $link, $matches)) {
		return $matches[1];
	} else {
		return false;
	}
}

if (file_exists(__DIR__ . '/module_updater.php'))
{
	include (__DIR__ . '/module_updater.php');
}