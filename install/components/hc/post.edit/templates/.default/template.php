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

		<form method="post" action="/house/<?= $arParams['housePath'] ?>/post/<?=$arResult['POST']['ID']?>/edit">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_REDACT_POST')?>
			</h1>
			<div class="field">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTADD_POST_TITLE')?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input" type="text" placeholder="Заголовок" name="post-caption" value="<?=$arResult['POST']['TITLE']?>">
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

			<?= \Bitrix\Main\UI\FileInput::createInstance(
				[
					"name" => "files[#IND#]",
					"description" => true,
					"upload" => true,
					"allowUpload" => "A",
					"medialib" => true,
					"fileDialog" => true,
					"delete" => true,
					"maxCount" => 10,
					"maxSize" => 50*1024*1024
				])->show(
						array_merge($arResult['POST']['FILES'], $arResult['POST']['IMAGES']), true
			) ?>

			</div>
			<div class="buttons">
				<button class="button mt-5" type="submit">Сохранить</button>
				<button class="button mt-5 is-warning" type="reset">Отменить</button>
			</div>
		</form>
	</div>
</div>