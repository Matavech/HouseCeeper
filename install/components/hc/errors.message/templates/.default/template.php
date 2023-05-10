<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?php if (isset($arParams['ERRORS'])) : ?>
	<div class="errors mt-3">
		<?php foreach ($arParams['ERRORS'] as $error): ?>
			<div class="notification is-warning">
				<?= $error ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
