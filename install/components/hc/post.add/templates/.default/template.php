<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<div class="content">

		<form method="post" action="/house/<?= $arParams['housePath'] ?>/add-post" enctype="multipart/form-data">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_NEW_POST')?>
			</h1>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POST_TITLE')?></label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" placeholder="Заголовок" name="post-caption">
				</div>
			</div>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POST_CONTENT')?></label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" placeholder="" name="post-body"></textarea>
				</div>
			</div>
			<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID())) :?>
			<div class="control">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_CHOSE_TYPE_OF_POST')?></label>
				<label class="radio">
					<input type="radio" name="post-type" value="announcement">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_ANNOUNCEMENT') ?>
				</label>
				<label class="radio">
					<input type="radio" name="post-type" value="discussion">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_DISCUSSION') ?>
				</label>
			</div>
			<?php endif; ?>

			<div class="file mt-5">
				<label class="file-label">
					<input class="file-input" type="file" name="files[]" multiple>
					<span class="file-cta">
						<span class="file-icon">
							<i class="fas fa-upload"></i>
						</span><span class="file-label">
							<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_CHOSE_FILES')?>
						</span>
					</span>
				</label>
			</div>
			<div class="container mt-5">
				<div class="input-file-list columns is-multiline"></div>
			</div>
			<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID())) :?>
			<button class="button mt-5" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_ADD_POST')?></button>
			<?php else : ?>
			<button class="button mt-5" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_ADD_POST_REQUEST')?></button>
			<?php endif; ?>
		</form>
	</div>
</div>