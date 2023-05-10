<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HouseCeeper");
global $USER;
if (!$USER->IsAuthorized()){
	LocalRedirect('/sign-in');
}
\Hc\Houseceeper\Controller\User::checkAccessToHouse();
$APPLICATION->IncludeComponent('hc:post.details', '', [
	'housePath' => $_REQUEST['housePath'],
	'id' => $_REQUEST['id'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>