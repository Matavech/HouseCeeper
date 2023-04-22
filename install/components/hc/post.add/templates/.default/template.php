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
				Новый пост
			</h1>
			<div class="field">
				<label class="label">Заголовок</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" placeholder="Заголовок" name="post-caption">
				</div>
			</div>
			<div class="field">
				<label class="label">Тело поста</label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" placeholder="" name="post-body"></textarea>
				</div>
			</div>
			<div class="control">
				<label class="label">Выберите тип поста</label>
				<label class="radio">
					<input type="radio" name="post-type" value="announcement">
					Объявление
				</label>
				<label class="radio">
					<input type="radio" name="post-type" value="discussion">
					Обсуждение
				</label>
			</div>

			<div class="file mt-5">
				<label class="file-label">
					<input class="file-input" type="file" name="files[]" multiple>
					<span class="file-cta">
						<span class="file-icon">
							<i class="fas fa-upload"></i>
						</span><span class="file-label">
							Выберите файлы...
						</span>
					</span>
				</label>
			</div>
			<div class="container mt-5">
				<div class="input-file-list columns is-multiline"></div>
			</div>
			<button class="button mt-5" type="submit">Добавить пост</button>
		</form>
	</div>
</div>