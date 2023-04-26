<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
define(__FILE__, '');
Loc::loadMessages(__FILE__);

class hc_houseceeper extends CModule
{
	public $MODULE_ID = 'hc.houseceeper';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct()
	{
		var_dump(Loc::getMessage('HC_HOUSECEEPER_MODULE_NAME'));
		$arModuleVersion = [];
		include(__DIR__ . '/version.php');

		if (is_array($arModuleVersion) && $arModuleVersion['VERSION'] && $arModuleVersion['VERSION_DATE'])
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->MODULE_NAME = Loc::getMessage('HC_HOUSECEEPER_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('HC_HOUSECEEPER_MODULE_DESCRIPTION');
	}

	public function installDB(): void
	{
		global $DB;

		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/db/install.sql');

		ModuleManager::registerModule($this->MODULE_ID);
	}

	public function uninstallDB($arParams = []): void
	{
		global $DB;

		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/db/uninstall.sql');

		ModuleManager::unRegisterModule($this->MODULE_ID);
	}

	public function installFiles(): void
	{
		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/components',
			$_SERVER['DOCUMENT_ROOT'] . '/local/components/',
			true,
			true
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/templates',
			$_SERVER['DOCUMENT_ROOT'] . '/local/templates/',
			true,
			true
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/routes',
			$_SERVER['DOCUMENT_ROOT'] . '/local/routes/',
			true,
			true
		);
	}

	public function uninstallFiles(): void
	{
	}

	public function installEvents(): void
	{
	}

	public function uninstallEvents(): void
	{
	}

	public function doInstall(): void
	{
		global $USER, $APPLICATION;

		if (!$USER->isAdmin())
		{
			return;
		}

		$this->installDB();
		$this->installFiles();
		$this->installEvents();

		$APPLICATION->IncludeAdminFile(
			Loc::getMessage('HC_HOUSECEEPER_INSTALL_TITLE'),
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/step.php'
		);
	}

	public function doUninstall(): void
	{
		global $USER, $APPLICATION, $step;

		if (!$USER->isAdmin())
		{
			return;
		}

		$step = (int)$step;
		if($step < 2)
		{
			$APPLICATION->IncludeAdminFile(
				Loc::getMessage('HC_HOUSECEEPER_UNINSTALL_TITLE'),
				$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep1.php'
			);

		}
		elseif($step === 2)
		{
			$this->uninstallDB();
			$this->uninstallFiles();
			$this->uninstallEvents();

			$APPLICATION->IncludeAdminFile(
				Loc::getMessage('HC_HOUSECEEPER_UNINSTALL_TITLE'),
				$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep2.php'
			);
		}

	}
}