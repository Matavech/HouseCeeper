<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var Cmain $APPLICATION
 */
global $USER;

\Bitrix\Main\UI\Extension::load("ui.vue3");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<div class="content">
		<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>
		<form method="post" action="edit-house">
			<fieldset <?= $USER->IsAdmin() ? '' : 'disabled' ?>>
				<?= bitrix_sessid_post(); ?>

				<div class="field mt-6">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_TITLE') ?></label>
					<div class="control">
						<input class="title input" type="text" name="houseName" style="cursor: text"
							   value="<?= htmlspecialcharsbx($arResult['HOUSE']['NAME']) ?>">
					</div>
				</div>

				<input type="hidden" name="houseId" value="<?= $arResult['HOUSE']['ID'] ?>">
				<div class="field">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_TECHNIC_INFO') ?></label>
					<div class="control">
						<textarea class="input" name="info"
								  style="cursor: text"> <?= $arResult['HOUSE']['INFO'] ?>  </textarea>
					</div>
				</div>
				<div class="field">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_UNIQ_ID') ?></label>
					<div class="control">
						<input class="input" type="text" value="<?= $arResult['HOUSE']['UNIQUE_PATH'] ?>"
							   style="cursor: text"
							   name="uniquePath">
					</div>
				</div>
				<div class="field">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_NUMBER_OF_APARTMENT') ?></label>
					<div class="control">
						<input class="input" type="number" name="numberOfApart" min="1"
							   style="cursor: text"
							   value="<?= $arResult['HOUSE']['NUMBER_OF_APARTMENT'] ?>">
					</div>
				</div>
				<div class="field">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_ADDRESS') ?></label>
					<div class="control">
						<input class="input" type="text" name="address" style="cursor: text"
							   value="<?= $arResult['HOUSE']['ADDRESS'] ?>">
					</div>
				</div>
				<?php if ($USER->IsAdmin()) { ?>
					<button class="button"
							type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_SAVE_CHANGES') ?></button>
				<?php } ?>
			</fieldset>
		</form>

		<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) { ?>
			<form method="get">
				<h3 class="title mt-6">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_GET_INVENTION_LINK') ?>
				</h3>
				<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
				<div class="field">
					<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_APARTMENT_NUMBER') ?></label>
					<div class="control">
						<input id="get-link" required class="input" type="number" name="number">
					</div>
				</div>
				<button class="button" type="submit"
						onclick="generateLink(event)"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSEDETAILS_GENERATE_LINK') ?></button>
				<span id="invite-key" class="tag is-large has-background-white"></span>
				<span id="invite-link" class="tag is-large has-background-white"></span>
			</form>
		<?php } ?>


		<div class="mt-6">
			<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) {
				$APPLICATION->IncludeComponent(
					'bitrix:main.ui.grid',
					'',
					[
						'GRID_ID' => 'apartment_list',
						'COLUMNS' => [
							['id' => 'NUMBER', 'name' => 'Номер', 'default' => true],
							['id' => 'USERS', 'name' => 'Жильцы', 'default' => true],
							['id' => 'LINK', 'name' => 'Ссылка-приглашение', 'default' => true]
						],
						'ROWS' => $arResult['GRID_LIST'],
						'SHOW_ROW_CHECKBOXES' => false,
						'NAV_OBJECT' => $arResult['NAV_OBJECT'],
						'AJAX_MODE' => 'Y',
						'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
						'SHOW_ROW_ACTIONS_MENU' => false,
						'SHOW_GRID_SETTINGS_MENU' => false,
						'SHOW_NAVIGATION_PANEL' => true,
						'SHOW_PAGINATION' => true,
						'SHOW_SELECTED_COUNTER' => false,
						'SHOW_TOTAL_COUNTER' => false,
						'SHOW_PAGESIZE' => true,
						'SHOW_ACTION_PANEL' => false,

						'ALLOW_COLUMNS_SORT' => false,
						'ALLOW_COLUMNS_RESIZE' => true,
						'ALLOW_HORIZONTAL_SCROLL' => false,
						'ALLOW_SORT' => false,
						'ALLOW_PIN_HEADER' => true,
						'AJAX_OPTION_HISTORY' => 'N'
					]
				);

			} ?>
		</div>
	</div>

</div>
</div>