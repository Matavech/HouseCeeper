<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="table-container">
	<table class="table">
		<tbody>
		<?php foreach ($arParams['USER_LIST'] as $user) { ?>
			<tr>
				<th style="width: 45px">
					<?php if (\Hc\Houseceeper\Repository\User::isHeadman($user['ID'], $arParams['HOUSE_ID'])) { ?>
						<i class="fa-solid fa-building-user"></i>
					<?php } else { ?>
						<i class="fa-solid fa-user"></i>
					<?php } ?>
				</th>
				<td style="width: 220px">
					<?= htmlspecialcharsbx($user['FULL_NAME']) ?>
				</td>
				<?php if ($USER->IsAdmin()) { ?>
					<td style="width: 250px">
						<?php if (\Hc\Houseceeper\Repository\User::isHeadman($user['ID'], $arParams['HOUSE_ID'])) { ?>
							<a href="delete-headman/<?= $user['ID']?>?sessid=<?= bitrix_sessid() ?>" class="button is-warning">
								<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_WITHDRAW_AUTHORITY') ?>
							</a>
						<?php } else { ?>
							<a href="add-headman/<?= $user['ID']?>?sessid=<?= bitrix_sessid() ?>" class="button is-primary">
								<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_ADD_HEADMAN') ?>
							</a>
						<?php } ?>
					</td>
					<td>
						<a href="remove-user/<?= $user['ID']?>/<?= $arParams['APARTMENT_ID'] ?>?sessid=<?= bitrix_sessid() ?>" class="button is-danger">
							<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_REMOVE_USER') ?>
						</a>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>


