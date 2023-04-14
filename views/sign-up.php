<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->SetTitle("HouseCeeper");

$APPLICATION->IncludeComponent('hc:sign.up', '', []);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>