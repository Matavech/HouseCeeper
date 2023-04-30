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

		<form method="post" action="/house/<?= $arParams['housePath'] ?>/post/<?=$arResult['POST']['ID']?>/edit">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_REDACT_POST')?>
			</h1>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_POST_TITLE')?></label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" placeholder="Заголовок" name="post-caption" value="<?=$arResult['POST']['TITLE']?>">
				</div>
			</div>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_POST_CONTENT')?></label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input"  name="post-body"> <?=$arResult['POST']['CONTENT']?></textarea>
				</div>
			</div>
				<div class="control">
					<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_CHOSE_TYPE_OF_POST')?></label>
					<label class="radio">
						<input type="radio" name="post-type" value="<?=\Hc\HouseCeeper\Constant\PostType::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT?>" <?= $arResult['POST']['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === \Hc\HouseCeeper\Constant\PostType::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT ?  'checked' : ''?>>
						<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_ANNOUNCEMENT') ?>
					</label>
					<label class="radio">
						<input type="radio" name="post-type" value="<?=\Hc\HouseCeeper\Constant\PostType::HC_HOUSECEEPER_POSTTYPE_DISCUSSION?>" <?= $arResult['POST']['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === \Hc\HouseCeeper\Constant\PostType::HC_HOUSECEEPER_POSTTYPE_DISCUSSION ?  'checked' : '' ?>>
						<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_DISCUSSION') ?>
					</label>
				</div>
				<h2>

				</h2>
			<?php if (isset($arResult['POST']['FILES'])) : ?>
				<h5>
					Прикрепленные файлы:
				</h5>
			<?php endif; ?>
			<?php foreach ($arResult['POST']['IMAGES'] as $image) {
				echo CFile::ShowImage($image['ID'], 400, 400, 'border=2px');
			} ?>

			<div>

				<?php foreach ($arResult['POST']['FILES'] as $file) { ?>
					<div>
						<a href="<?= $file['SRC'] ?>" download="<?= $file['ORIGINAL_NAME'] ?>">
							<i class="fas fa-file" aria-hidden="true"></i>
							<?= $file['ORIGINAL_NAME'] ?>
							<i class="fas fa-download" aria-hidden="true"></i>
						</a>
					</div>
				<?php } ?>
			</div>
			</div>
			<div class="buttons">
				<button class="button mt-5" type="submit">Сохранить</button>
				<button class="button mt-5 is-warning" type="reset">Отменить</button>
			</div>
		</form>
	</div>
</div>