<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HouseCeeper");

$APPLICATION->IncludeComponent('hc:sign.up', '', [
	'key' => $_REQUEST['key'],
]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>