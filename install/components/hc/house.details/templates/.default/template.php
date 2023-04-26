<?php

/**
 * @var array $arResult
 * @var array $arParams
 */
global $USER;

\Bitrix\Main\UI\Extension::load("ui.vue3");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<div class="content">

		<form method="post" action="edit-house">
			<fieldset <?= $USER->IsAdmin() ? '' : 'disabled' ?>>
				<?php bitrix_sessid_post(); ?>

				<div class="field mt-6">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_TITLE')?></label>
					<div class="control">
						<input class="title input" type="text" name="house-name" style="cursor: text"
							   value="<?= htmlspecialcharsbx($arResult['HOUSE']['NAME']) ?>">
					</div>
				</div>

				<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
				<div class="field">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_TECHNIC_INFO')?></label>
					<div class="control">
						<textarea class="input" name="info" style="cursor: text"> <?= $arResult['HOUSE']['INFO'] ?>  </textarea>
					</div>
				</div>
				<div class="field">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_UNIQ_ID')?></label>
					<div class="control">
						<input required class="input" type="text" value="<?= $arResult['HOUSE']['UNIQUE_PATH'] ?> " style="cursor: text"
							   name="unique-path">
					</div>
				</div>
				<div class="field">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_NUMBER_OF_APARTMENT')?></label>
					<div class="control">
						<input required class="input" type="number" name="number-of-apartments" min="1" style="cursor: text"
							   value="<?= $arResult['HOUSE']['NUMBER_OF_APARTMENT'] ?>">
					</div>
				</div>
				<div class="field">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_ADDRESS')?></label>
					<div class="control">
						<input required class="input" type="text" name="address" style="cursor: text"
							   value="<?= $arResult['HOUSE']['ADDRESS'] ?>">
					</div>
				</div>
				<?php if ($USER->IsAdmin()) { ?>
					<button class="button" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_SAVE_CHANGES')?></button>
				<?php } ?>
			</fieldset>
		</form>

		<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) { ?>
		<form method="get">
			<h3 class="title mt-6">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_GET_INVENTION_LINK')?>
			</h3>
			<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_APARTMENT_NUMBER')?></label>
				<div class="control">
					<input id="get-link" required class="input" type="number" name="number">
				</div>
			</div>
			<button class="button" type="submit" onclick="generateLink(event)"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_GENERATE_LINK')?></button>
			<span id="invite-key" class="tag is-large has-background-white"></span>
			<span id="invite-link" class="tag is-large has-background-white"></span>
		</form>
		<?php } ?>

		<h3 class="title mt-6">
			<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_HEADMANS')?>
		</h3>
		<div class='container'>
			<div class="columns is-multiline">
				<?php foreach ($arResult['HEADMEN_LIST'] as $headman) { ?>
					<div class="card column is-3">
						<div class="card-header">
							<p class="card-header-title">
								<?= htmlspecialcharsbx($headman['NAME']) ?>
								<?= htmlspecialcharsbx($headman['LAST_NAME']) ?>
							</p>
						</div>
						<p class="card-content subtitle is-6"><?= $headman['EMAIL'] ?></p>
						<?php if ($USER->IsAdmin()) { ?>
							<div class="card-footer">
								<form method="post" action="delete-headman" class="card-footer-item">
									<fieldset <?= $USER->IsAdmin() ? '' : 'disabled' ?>>
										<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
										<input type="hidden" name="headman-id" value="<?= $headman['ID'] ?>">
										<button type="submit" class="button is-danger "><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_WITHDRAW_AUTHORITY')?></button>
									</fieldset>
								</form>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($USER->IsAdmin()) { ?>
					<div class="card column is-3">
						<div class="card-header">
							<p class="card-header-title"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_ADD_HEADMAN')?></p>
						</div>
						<div class="card-content">
							<?php foreach ($arResult['USER_LIST'] as $user) { ?>
								<p>
								<form method="post" action="add-headman"
									  class="is-flex is-justify-content-space-between">
									<div>
										<?= htmlspecialcharsbx($user['NAME']) ?>
										<?= htmlspecialcharsbx($user['LAST_NAME']) ?>
									</div>
									<fieldset>
										<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
										<input type="hidden" name="user-id" value="<?= $user['ID'] ?>">
										<button type="submit" class="button is-primary "><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_CHOSE')?></button>
									</fieldset>
								</form>
								</p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>