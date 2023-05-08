<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

?>
<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>

<div class="container">
	<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>
	<div class="content mt-5">
		<div class="columns">
			<div class="column mr-5">
				<h1 class="has-text-primary-dark"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_MAIN_INFO')?></h1>
				<form action="/profile/changeGeneral" method="post">
					<?= bitrix_sessid_post() ?>
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_NAME')?></h2>
					<input class="input" type="text" id="userName" name="userName"
						   value="<?= $arResult['USER']['NAME'] ?>" readonly required>
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_LAST_NAME')?></h2>
					<input class="input" type="text" id="userLastName" name="userLastName"
						   value="<?= $arResult['USER']['LAST_NAME'] ?>" readonly>
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_LOGIN')?></h2>
					<input class="input" type="text" id="userLogin" name="userLogin"
						   value="<?= $arResult['USER']['LOGIN'] ?>" readonly required>
					<input type="hidden" value="<?= $arResult['USER']['ID'] ?>" name="userId">
					<button class="button is-success mt-3" type="submit" id="save" onclick="hide();"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_SAVE')?></button>
					<button class="button is-warning mt-3" type="reset" id="reset" onclick="hide();"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CANCEL')?></button>
				</form>
				<button class="button is-success mt-3" id="change" onclick="openChanges();"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CHANGE_PARAMETERS')?></button>


			</div>
			<div class="column mr-5">
				<h1 class="has-text-primary-dark"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_AVATAR')?></h1>
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CURRENT_AVATAR')?></h2>
				<?php if(!$arResult['USER']['AVATAR']) : ?>
				<p><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_NOT_SET')?></p>
					<button class="button is-success mt-3 js-modal-trigger" data-target="modal-js-example">
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_ADD_AVATAR')?>
					</button>
				<?php else: ?>
					<figure class="media is-left">
						<?= CFile::ShowImage($arResult['USER']['AVATAR'], 300, 300, 'border=2px'); ?>
					</figure>
				<button class="button is-success mt-3 js-modal-trigger" data-target="modal-js-example">
					<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CHANGE_AVATAR')?>
				</button>
					<form action="/profile/deleteAvatar" method="get">
						<?= bitrix_sessid_post() ?>
						<button type="submit" class="button is-danger"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_DELETE_AVATAR')?></button>
					</form>
				<?php endif; ?>

			</div>
			<div class="column ml-5">
				<h1 class="has-text-primary-dark"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CHANGE_PASSWORD')?></h1>
				<form action="/profile/changePassword" method="post">
					<?= bitrix_sessid_post() ?>
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_OLD_PASSWORD')?></h2>
					<input type="password" class="input" name="oldPassword" >
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_NEW_PASSWORD')?></h2>
					<input type="password" class="input" name="newPassword" >
					<h2><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CONFIRM_PASSWORD')?></h2>
					<input type="password" class="input" name="confirmPassword" >
					<button class="button is-success mt-3" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_CONFIRM')?></button>
				</form>

			</div>
		</div>
		<?php if (!$USER->IsAdmin() && count($arResult['HOUSES'])): ?>
			<h1 class="has-text-primary-dark has-text-centered"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_HOUSE_INFO')?></h1>
			<?php foreach ($arResult['HOUSES'] as $house) : ?>
				<section class="section">
					<h1 class="title">
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_HOUSE_NAME')?>: <?= $house['NAME'] ?>
					</h1>
					<h2 class="subtitle">
						<strong><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_ADDRESS')?>: </strong><?= $house['ADDRESS'] ?>
						<br>
						<strong><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_APARTMENTS')?>: </strong>
						<?php foreach ($house['APARTMENTS'] as $key => $apartment)  : ?>
							<div class="buttons">
								<form action="/profile/leaveApartment" method="post" class="mt-3">
									<?= bitrix_sessid_post() ?>
									<input type="hidden" name="houseId" value="<?= $house['ID'] ?>">
									<input type="hidden" name="apartmentId" value="<?= $apartment ?>">
									<div class="buttons has-addons">
										<button class="button is-black disabled" disabled>
											<?= $key ?>
										</button>
										<button class="button is-warning" type="submit">
											<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_MOVE_OUT')?>
										</button>
									</div>
								</form>
							</div>
						<?php endforeach; ?>
					</h2>
					<form action="/profile/leaveHouse" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="houseId" value="<?= $house['ID'] ?>">
						<button class="button is-danger" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_LEAVE_HOUSE')?></button>
					</form>
				</section>
			<?php endforeach; ?>
		<?php endif ?>
	</div>
</div>
<div id="modal-js-example" class="modal">
	<form action="profile/changeAvatar" method="post">
		<?= bitrix_sessid_post() ?>
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="box">
				<?= $arResult['FILES']->show(); ?>
				<div class="buttons mt-3">
					<button class="button is-success" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PROFILE_SAVE')?></button>
				</div>
			</div>
		</div>
	</form>
</div>
