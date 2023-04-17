<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
if (!$USER->IsAuthorized()){
	LocalRedirect('/sign-in');
}
$APPLICATION->SetTitle("HouseCeeper about");

$APPLICATION->IncludeComponent('hc:house.details', '', [
	'housePath' => $_REQUEST['housePath'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>