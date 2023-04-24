<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
if (!$USER->IsAdmin()){
	LocalRedirect('/sign-in');
}
$APPLICATION->SetTitle("HouseCeeper admin");

$APPLICATION->IncludeComponent('hc:house.add', '', [
	'housePath' => $_REQUEST['housePath'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>