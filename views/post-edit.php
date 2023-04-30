<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HouseCeeper");

$houseId = \Hc\Houseceeper\Repository\House::getIdByPath($_REQUEST['housePath']);
global $USER;
if ( !$USER->IsAdmin() && !\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $houseId)){
	LocalRedirect('/sign-in');
}
$APPLICATION->IncludeComponent('hc:post.edit', '', [
	'housePath' => $_REQUEST['housePath'],
	'id' => $_REQUEST['id'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>