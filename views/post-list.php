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

$APPLICATION->IncludeComponent('hc:post.list', '', [
	'housePath' => $_REQUEST['housePath'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>