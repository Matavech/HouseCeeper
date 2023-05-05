<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\UI\Extension::load('hc.hc-constantmanager');
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>

<main>
	<div class="container mt-5 mb-5">
		<section class="hero post">
			<div class="hero-body">
				<h1 class="title">
			<span id="type" class="tag is-medium" >
  				<?=$arResult['POST']['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] ?>
			</span>
					<?= htmlspecialcharsbx($arResult['POST']['TITLE'])?>
				</h1>
				<h2 class="subtitle mt-5">
					<?= htmlspecialcharsbx($arResult['POST']['CONTENT'])?>
				</h2>
				<h5 class="date-published">
					<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_PUBLISHED')?>: <?=$arResult['POST']['DATETIME_CREATED'] ?> <br>
				</h5>
				<h5 class="user-info">
					<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_USER')?>:
					<?php if (\Hc\Houseceeper\Repository\User::isAdmin($arResult['POST']['USER_ID'])) : echo '<strong>'; ?>
					<?php endif ?>
					<?= htmlspecialcharsbx($arResult['POST']['USER']['NAME'])?>
					<?= htmlspecialcharsbx($arResult['POST']['USER']['LAST_NAME'])?>
					<?php if (\Hc\Houseceeper\Repository\User::isAdmin($arResult['POST']['USER_ID'])) : echo '</strong>'; ?>
					<?php endif ?>
				</h5>


				<?php if (isset($arResult['POST']['FILES'])) : ?>
					<h5>
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_ATTACHED_FILES')?>:
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
				<?php if (\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['POST']['HOUSE_ID']) || $USER->IsAdmin()) :?>
				<?php if ($arResult['POST']['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === 'unconfirmed') : ?>
						<a onclick="return confirm('<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_ARE_YOU_SURE_YOU_CONFIRM_PUBLICATION')?>?')" class="button is-success" href="/house/<?=$arParams['housePath']?>/post/<?=$arResult['POST']['ID']?>/confirm"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_CONFIRM_PUBLICATION')?></a>
					<?php endif; ?>
					<a onclick="return confirm('<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_ARE_YOU_SURE_YOU_DELETE_PUBLICATION')?>')" class="button is-danger" href="/house/<?=$arParams['housePath']?>/post/<?=$arResult['POST']['ID']?>/delete"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_DELETE_PUBLICATION')?></a>
					<a href="/house/<?=$arParams['housePath']?>/post/<?=$arResult['POST']['ID']?>/edit" class="button is-success">Редактировать</a>
				<?php endif; ?>
				<?php if ($arResult['POST']['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === 'discussion') :?>
				<h1 class="title mt-5"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_COMMENTS')?></h1>
				<article class="media">

					<div class="media-content">
						<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>
						<form method="post" action="/house/<?=$arParams['housePath']?>/post/<?=$arResult['POST']['ID']?>">
							<?php bitrix_sessid_post(); ?>
							<div class="field">
								<p class="control">
									<textarea class="textarea" id="inputComment" name="content" placeholder="<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_ADD_COMMENT')?>..."></textarea>
								</p>
								<input id="parentCommentId" type="hidden" name="parentId" value="">
							</div>

							<div class="level-left">
								<div class="level-item">
									<button class="button is-info" type="submit"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTDETAILS_SUBMIT')?></button>
								</div>
							</div>
						</form>
					</div>

				</article>
				<?php $comment = new \Hc\Houseceeper\Controller\Comment();
				$comment->getComments($arResult['POST']['ID']);
				endif; ?>
			</div>
		</section>
	</div>
</main>

