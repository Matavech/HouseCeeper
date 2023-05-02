<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<article class="media comment mt-3 lvl-<?=$arParams['LEVEL']?>">
	<figure class="media-left">
		<p class="image is-64x64">
			<img src="<?= $arParams['COMMENT']['USER_AVATAR'] ?>">
		</p>
	</figure>
	<div class="media-content">
		<div class="content">
			<p>
				<strong id="username"><?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_NAME'] ?> <?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_LAST_NAME'] ?></strong> <small> <?=$arParams['COMMENT']['USER_APARTMENT_NUMBER']?> <?=$arParams['COMMENT']['USER_APARTMENT']?></small>
				<button onclick="replyToComment(<?=$arParams['COMMENT']['ID'] ?>, '<?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_NAME'] ?>' )" class="button is-small">
								<span class="icon">
									<i class="fa-solid fa-reply"></i></a>
								</span>
				</button>
				<br>
				<small id="dateId"> <?= $arParams['COMMENT']['DATETIME_CREATED']?> </small>
				<br>
				<?= $arParams['COMMENT']['CONTENT']?>
			</p>
		</div>
	</div>

	<?php if ($USER->GetID()===$arParams['COMMENT']['USER_ID'] || \Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID']) || $USER->IsAdmin()) : ?>
	<form action="/house/<?=$_REQUEST['housePath']?>/post/<?=$_REQUEST['id']?>/deleteComment" method="post">
		<input type="hidden" name="commentId" value="<?=$arParams['COMMENT']['ID']?>">
		<input type="hidden" name="houseId" value="<?=$arResult['HOUSE']['ID']?>">
		<button  onclick="return confirm(<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_COMMENT_ARE_YOU_SURE_YOU_WANT_DELETE')?>)" type="submit" class="button is-small">
								<span class="icon">
									<i class="fa-solid fa-xmark"></i>
								</span>
		</button>
	</form>
<!--	<form action="/house/--><?//=$_REQUEST['housePath']?><!--/post/--><?//=$_REQUEST['id']?><!--/changeComment" method="post">-->
<!--		<button class="button is-small ml-1">-->
<!--								<span class="icon">-->
<!--									<i class="fa-solid fa-pencil"></i>-->
<!--								</span>-->
<!--		</button>-->
<!--	</form>-->
	<?php endif; ?>
</article>