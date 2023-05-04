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
		<?php if(isset($arResult['ERRORS'])) : ?>
		<div class="errors mt-3">
			<?php foreach($arResult['ERRORS'] as $error): ?>
				<div class="notification is-warning">
					<?= $error?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<form method="post" action="/house/<?= $arParams['housePath'] ?>/add-post" enctype="multipart/form-data">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_NEW_POST')?>
			</h1>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_POST_TITLE')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" placeholder="Заголовок" name="post-caption">
				</div>
			</div>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_POST_CONTENT')?></label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" placeholder="<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_TYPE_POST_CONTENT')?>" name="post-body"></textarea>
				</div>
			</div>
			<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) :?>
			<div class="control">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_CHOSE_TYPE_OF_POST')?></label>
				<label class="radio">
					<input type="radio" name="post-type" value="announcement">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_ANNOUNCEMENT') ?>
				</label>
				<label class="radio">
					<input type="radio" name="post-type" value="discussion">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_DISCUSSION') ?>
				</label>
			</div>
			<?php endif; ?>

<!--			<div class="file mt-5">-->
<!--				<label class="file-label">-->
<!--					<input class="file-input" type="file" name="files[]" multiple>-->
<!--					<span class="file-cta">-->
<!--						<span class="file-icon">-->
<!--							<i class="fas fa-upload"></i>-->
<!--						</span><span class="file-label">-->
<!--							Выберите файлы...-->
<!--						</span>-->
<!--					</span>-->
<!--				</label>-->
<!--			</div>-->

				<?=$arResult['FILES']->show(); ?>

<!--			<div class="container mt-5">-->
<!--				<div class="input-file-list columns is-multiline"></div>-->
<!--			</div>-->
			<?php if ($USER->IsAdmin() || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) :?>
			<button class="button mt-5" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_ADD_POST')?></button>
			<?php else : ?>
			<button class="button mt-5" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_ADD_POST_REQUEST')?></button>
			<?php endif; ?>
		</form>
	</div>
</div>