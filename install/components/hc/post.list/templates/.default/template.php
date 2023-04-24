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
		<!--	ДЛЯ СТРАНИЦ ОБЪЯВЛЕНИЯ И ОБСУЖДЕНИЯ -->
		<!--	<div class="columns ">-->
		<!--		<div class="column is-3">-->
		<!--			<div class="tabs">-->
		<!--				<ul>-->
		<!--					<li class="is-active"><a>All</a></li>-->
		<!--					<li><a>Discussions</a></li>-->
		<!--					<li><a>Announcements</a></li>-->
		<!--				</ul>-->
		<!--			</div>-->
		<!--		</div>-->
		<!--	<div class="column">-->
		<!--		<div class="field has-addons mt-5 ml-6">-->
		<!--			<p class="control">-->
		<!--				<input class="input" type="text" placeholder="Find a post">-->
		<!--			</p>-->
		<!--			<p class="control">-->
		<!--				<button class="button">-->
		<!--					Search-->
		<!--				</button>-->
		<!--			</p>-->
		<!--		</div>-->
		<!--	</div>-->
		<!--	</div>-->
		<!--	<section class="section">-->
		<!--		<h1 class="title">-->
		<!--			<span class="tag is-danger is-medium">-->
		<!--  				Объявление-->
		<!--			</span>-->
		<!--			<a href="">Отключение горячей воды</a>-->
		<!--		</h1>-->
		<!--		<h2 class="subtitle">-->
		<!--			24.04.2023 во всем доме будет отключена горячая вода для проведения ремонтых работ. Надеемся на ваше понимание!-->
		<!--		</h2>-->
		<!--		<h5 >Опубликовано: 16.04.2023</h5>-->
		<!--		<a class="button is-dark" href="#">Перейти к обсуждению</a>-->
		<!--	</section>-->
		<!--	<section class="section">-->
		<!--		<h1 class="title">-->
		<!--			<span class="tag is-warning is-medium">-->
		<!--  				Обсуждение-->
		<!--			</span>-->
		<!--			<a href="">Установка видеокамер в подъездах</a>-->
		<!--		</h1>-->
		<!--		<h2 class="subtitle">-->
		<!--			С целью предотвратить воровство велосипедов из подъездов, было предложено установить камеры видеонаблюдения на первом этаже всех подъездов-->
		<!--		</h2>-->
		<!---->
		<!--		<h5 >Опубликовано: 10.04.2023</h5>-->
		<!---->
		<!--		<a class="button is-dark" href="#">Перейти к обсуждению</a>-->
		<!--	</section>-->
		<!--	<section class="section">-->
		<!--		<h1 class="title">-->
		<!--			<span class="tag is-danger is-medium">-->
		<!--  				Объявление-->
		<!--			</span>-->
		<!--			<a href="">Внимание, мошенники!</a>-->
		<!--		</h1>-->
		<!--		<h2 class="subtitle">-->
		<!--			Участились случаи проникновения мошенников в квартиры под видом сотрудников газовой службы. Будьте внимательны! Обо всех посещениях настоящих газовщиков мы предупреждаем заранее!-->
		<!--		</h2>-->
		<!--		<h5>Опубликовано: 04.04.2023</h5>-->
		<!---->
		<!--		<a class="button is-dark" href="#">Перейти к обсуждению</a>-->

		<?php foreach ($arResult['POSTS'] as $post) { ?>
			<?php if ($post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === 'unconfirmed' &&
				!$USER->IsAdmin() && !\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID())) continue ?>
			<section class="section post">
				<h1 class="title">
					<a href="/house/<?= $arParams['housePath'] . '/post/' . $post['ID'] ?>"><?= htmlspecialcharsbx($post['TITLE']) ?></a>
					<span class="tag is-medium" id="type">
		  				<?= $post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] ?>
					</span>
				</h1>
				<h2 class="subtitle">
					<?= htmlspecialcharsbx($post['CONTENT']) ?>
				</h2>
				<h5>Опубликовано: <?= $post['DATETIME_CREATED'] ?></h5>
				<a class="button is-dark" href="/house/<?= $arParams['housePath'] . '/post/' . $post['ID'] ?>">Перейти к обсуждению</a>
			</section>
		<?php } ?>
	</div>

	<?php if ($arResult['NAV_OBJECT']->getPageCount() > 1): ?>
		<div class="pagination">
			<?php $APPLICATION->IncludeComponent(
				"bitrix:main.pagenavigation",
				"",
				array(
					"NAV_OBJECT" => $arResult["NAV_OBJECT"],
					"SEF_MODE" => "N",
					"SHOW_ALWAYS" => "Y"
				),
				false
			); ?>
		</div>
	<?php endif; ?>
</div>