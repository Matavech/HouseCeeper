<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<main>
	<div class="container mt-5">
		<section class="hero">
			<div class="hero-body">
				<h1 class="title">
			<span class="tag is-danger is-medium">
  				Объявление
			</span>
					Отключение горячей воды
				</h1>
				<h2 class="subtitle">
					24.04.2023 во всем доме будет отключена горячая вода для проведения ремонтых работ. Надеемся на ваше понимание!
				</h2>
				<h5 >Опубликовано: 16.04.2023</h5>

				<h1 class="title mt-5">Комментарии</h1>
				<article class="media comment">

					<figure class="media-left">
						<p class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png">
						</p>
					</figure>
					<div class="media-content">
						<div class="content">
							<p>
								<strong>Иван Битриксовский</strong> <small>Квартира 11, 29</small> <br> <small>1 день назад</small>
								<br>
								Совсем оборзели. Еще бы за час предупредили!
							</p>
						</div>
					</div>

				</article>

				<article class="media comment">

					<figure class="media-left">
						<p class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png">
						</p>
					</figure>
					<div class="media-content">
						<div class="content">
							<p>
								<strong>Станислав Душниловский</strong> <small>Квартира 32</small> <br> <small>13 часов назад</small>
								<br>
								Ни стыда, ни совести! Весь день ни помыться, ни побриться.
							</p>
						</div>
					</div>

				</article>

				<article class="media comment">

					<figure class="media-left">
						<p class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png">
						</p>
					</figure>
					<div class="media-content">
						<div class="content">
							<p>
								<strong>Вы</strong> <small>Квартира 13</small> <br> <small>31 минуту назад</small>
								<br>
								Да ладно вам ребят! Потерпим немного, не на неделю же отключают
							</p>
						</div>
					</div>

					<form action="deleteComment" method="post">
						<button class="button is-small">
								<span class="icon">
									<i class="fa-solid fa-xmark"></i>
								</span>
						</button>
					</form>
					<form action="changeComment" method="post">
						<button class="button is-small ml-1">
								<span class="icon">
									<i class="fa-solid fa-pencil"></i>
								</span>
						</button>
					</form>
				</article>

				<article class="media">
					<figure class="media-left">
						<p class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png">
						</p>
					</figure>
					<div class="media-content">
						<div class="field">
							<p class="control">
								<textarea class="textarea" placeholder="Add a comment..."></textarea>
							</p>
						</div>
						<nav class="level">
							<div class="level-left">
								<div class="level-item">
									<a class="button is-info">Submit</a>
								</div>
							</div>
						</nav>
					</div>
				</article>
			</div>
		</section>
	</div>
</main>