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
			<img src="https://bulma.io/images/placeholders/128x128.png">
		</p>
	</figure>
	<div class="media-content">
		<div class="content">
			<p>
				<strong id="username"><?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_NAME'] ?> <?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_LAST_NAME'] ?></strong> <small>Квартира 11, 29</small>
				<button onclick="replyToComment(<?=$arParams['COMMENT']['ID'] ?>, '<?= $arParams['COMMENT']['HC_HOUSECEEPER_MODEL_COMMENT_USER_NAME'] ?>' )" class="button is-small">
								<span class="icon">
									<i class="fa-solid fa-reply"></i></a>
								</span>
				</button>
				<br>
				<small id="dateId"> <?= $arParams['COMMENT']['DATETIME_CREATED']->toString()?> </small>
				<br>
				<?= $arParams['COMMENT']['CONTENT']?>
			</p>
		</div>
	</div>

	<?php if ($USER->IsAdmin() || $USER->GetID()===$arParams['COMMENT']['USER_ID']) : ?>
	<form action="/house/<?=$_REQUEST['housePath']?>/post/<?=$_REQUEST['id']?>/deleteComment" method="post">
		<input type="hidden" name="commentId" value="<?=$arParams['COMMENT']['ID']?>">
		<button type="submit" class="button is-small">
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