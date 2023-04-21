<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
				<h2 class="subtitle">
					<?= htmlspecialcharsbx($arResult['POST']['CONTENT'])?>
				</h2>
				<h5 >
					Опубликовано: <?=$arResult['POST']['DATETIME_CREATED'] ?> <br>
					Пользователь: <?= htmlspecialcharsbx($arResult['POST']['USER']['NAME'])?>
					<?= htmlspecialcharsbx($arResult['POST']['USER']['LAST_NAME'])?>
				</h5>

				<h1 class="title mt-5">Комментарии</h1>
				<article class="media">

					<div class="media-content">
						<form method="post" action="/house/<?=$arParams['housePath']?>/post/<?=$arResult['POST']['ID']?>">
							<?php bitrix_sessid_post(); ?>
							<div class="field">
								<p class="control">
									<textarea required class="textarea" id="inputComment" name="content" placeholder="Add a comment..."></textarea>
								</p>
								<input id="parentCommentId" type="hidden" name="parentId" value="">
							</div>

							<div class="level-left">
								<div class="level-item">
									<button class="button is-info" type="submit">Submit</button>
								</div>
							</div>
						</form>
					</div>

				</article>
				<?php $comment = new \Hc\Houseceeper\Controller\Comment();
				$comment->getComments($arResult['POST']['ID']);
				?>
			</div>
		</section>
	</div>
</main>