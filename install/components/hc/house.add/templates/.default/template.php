<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<div class="content">
		<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>
		<form method="post" action="/add-house">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_ADD_NEW_HOUSE')?>
			</h1>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_HOUSE_NAME')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" placeholder="дом" name="house-name">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_TECHNIC_INFO')?></label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" placeholder="" name="info"></textarea>
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_UNIQ_ID')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" placeholder="dom1" name="unique-path">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_NUMBER_OF_APARTMENT')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" min="1" type="number" name="number-of-apartments">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_ADDRESS')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" name="address">
				</div>
			</div>
			<h1 class="title">
				<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_HEADMAN_PROFILE')?>
			</h1>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_NAME')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" name="headman-name">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_LAST_NAME')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" name="headman-lastname">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_EMAIL')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="email" name="headman-email">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_APARTMENT_NUMBER')?></label>
				<div class="control has-icons-left has-icons-right">
					<input min="1" type="number" name="headman-apartment-number">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_LOGIN')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" name="headman-login">
				</div>
			</div>
			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_PASSWORD')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="password" name="headman-password">
				</div>
			</div>
			<button class="button" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEADD_ADD_HOUSE')?></button>
		</form>

	</div>
</div>