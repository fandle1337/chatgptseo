<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use Bitrix\Main\Type\DateTime;
use Skyweb24\Chatgptseo\Controller\Event\EventIncludeExtension;
use Skyweb24\Chatgptseo\Controller\Event\GridManager;
use Skyweb24\ChatgptSeo\Core\Informer;

class skyweb24_chatgptseo extends CModule
{
    const MODULE_ID = 'skyweb24.chatgptseo';
    const PROVIDER_ID = 'skyweb24_chatgptseo';
    var $MODULE_ID = 'skyweb24.chatgptseo';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $strError = '';

    function __construct()
    {
        $arModuleVersion = [];
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("skyweb24.chatgptseo_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("skyweb24.chatgptseo_MODULE_DESC");
        $this->PARTNER_NAME = Loc::getMessage("skyweb24.chatgptseo_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("skyweb24.chatgptseo_PARTNER_URI");
    }

    function InstallDB($arParams = [])
    {
        global $DB;
        $DB->Query('CREATE TABLE `skyweb24_chatgpt_seo_tasks`
                    (
                        `id`             INT(255)  NOT NULL AUTO_INCREMENT,
                        `user_id`      INT(255)  NULL     DEFAULT NULL,
                        `iblock_id`      INT(255)  NULL     DEFAULT NULL,
                        `date_create`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `date_complete`  TIMESTAMP NULL     DEFAULT NULL,
                        `status_id`      INT(255)  NULL     DEFAULT NULL,
                        `operation_type` TEXT(255) NULL     DEFAULT NULL,
                        `element_type`   TEXT(255) NULL     DEFAULT NULL,
                        `incorrect_text` LONGTEXT  NULL     DEFAULT NULL,
                        `operations`     LONGTEXT  NULL     DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        INDEX (`user_id`),
                        INDEX (`iblock_id`),
                        INDEX (`date_create`),
                        INDEX (`date_complete`),
                        INDEX (`status_id`)
                    )
                        ENGINE = InnoDB;
                        ');
        $DB->Query('CREATE TABLE `skyweb24_chatgpt_seo_tasks_elements`
                    (
                        `id`         INT(255) NOT NULL AUTO_INCREMENT,
                        `task_id`    INT(255) NULL DEFAULT NULL,
                        `element_id` INT(255) NULL DEFAULT NULL,
                        `status_id`  INT(255) NULL DEFAULT NULL,
                        PRIMARY KEY (id),
                        INDEX (task_id),
                        INDEX (element_id),
                        INDEX (status_id)
                    )
                        ENGINE = InnoDB;
                        ');
    }

    function UninstallDB($arParams = [])
    {
        global $DB;
        $DB->Query('DROP TABLE `skyweb24_chatgpt_seo_tasks`');
        $DB->Query('DROP TABLE `skyweb24_chatgpt_seo_tasks_elements`');
    }

    function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            'main',
            'OnEpilog',
            $this->MODULE_ID,
            EventIncludeExtension::class,
            'OnEpilog',
        );

        EventManager::getInstance()->registerEventHandler(
            'main',
            'OnAdminListDisplay',
            $this->MODULE_ID,
            GridManager::class,
            'manage',
        );

        EventManager::getInstance()->registerEventHandler(
            "main",
            "OnModuleUpdate",
            $this->MODULE_ID,
            Informer::class,
            "clearModuleCache"
        );


        return true;
    }

    function UninstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnEpilog",
            $this->MODULE_ID,
            EventIncludeExtension::class,
            "OnEpilog"
        );

        EventManager::getInstance()->unRegisterEventHandler(
            'main',
            'OnEpilog',
            $this->MODULE_ID,
            GridManager::class,
            'manage',
        );

        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnModuleUpdate",
            $this->MODULE_ID,
            Informer::class,
            "clearModuleCache"
        );

        return true;
    }

    function InstallAgents()
    {
        CAgent::AddAgent(
            '\Skyweb24\ChatgptSeo\Controller\Agent\AgentManagerTask::handle();',
            $this->MODULE_ID,
            'N',
            60,
            '',
            'Y',
            (new \Bitrix\Main\Type\DateTime())->toString(),
        );
    }

    function UninstallAgents()
    {
        CAgent::RemoveAgent(
            '\Skyweb24\ChatgptSeo\Controller\Agent\AgentManagerTask::handle();',
            $this->MODULE_ID,
        );
    }

    function InstallFiles($arParams = [])
    {
        if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/admin')) {
            if ($dir = opendir($p)) {
                while (false !== $item = readdir($dir)) {
                    if ($item == '..' || $item == '.' || $item == 'menu.php')
                        continue;

                    file_put_contents(
                        $file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . self::PROVIDER_ID . '_' . $item,
                        '<' . '? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/' . $this->MODULE_ID . '/admin/' . $item . '");?' . '>'
                    );

                }
                closedir($dir);
            }
        }
        if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/components')) {
            if ($dir = opendir($p)) {
                while (false !== $item = readdir($dir)) {
                    if ($item == '..' || $item == '.')
                        continue;
                    CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $item, $ReWrite = True, $Recursive = True);
                }
                closedir($dir);
            }
        }
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/js', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/js', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/css', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/css', true, true);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/themes", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes", true, true);
        return true;
    }

    function UninstallFiles()
    {
        if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/admin')) {
            if ($dir = opendir($p)) {
                while (false !== $item = readdir($dir)) {
                    if ($item == '..' || $item == '.')
                        continue;
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . self::PROVIDER_ID . '_' . $item);
                }
                closedir($dir);
            }
        }
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/js", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js");
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/css", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/css");
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/themes/.default/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/themes/.default");
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;

        if (!$this->isMeetRequirements("8.1.0", "23.0.0")) {

            $this->pushClientReject();

            $APPLICATION->ThrowException(
                Loc::getMessage("SKYWEB24_CHATGPTSEO_INSTALL_IS_NOT_MEET_REQUIREMENTS")
            );

            return false;
        }

        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallAgents();
        $this->InstallEvents();
        RegisterModule($this->MODULE_ID);

        \Bitrix\Main\Loader::includeModule($this->MODULE_ID);

        ServiceLocator::getInstance()->get(\Skyweb24\ChatGptSeo\Core\Service\Api\Client::class)
            ->install();

        ServiceLocator::getInstance()->get(\Skyweb24\ChatgptSeo\Service\Api\Module\Client::class)
            ->install();
    }

    public static function isMeetPhp(string $v): bool
    {
        return \version_compare(\phpversion(), $v, ">=");
    }

    public static function isMeetRequirements(string $php = "8.1.0", string $bitrixVersion = "22.0.0"): bool
    {
        if (!self::isMeetPhp($php) or !self::isMeetBitrixVersion($bitrixVersion)) {
            return \false;
        }
        return \true;
    }

    public static function isMeetBitrixVersion(string $v): bool
    {
        return \version_compare(self::getBitrixVersion(), $v, ">=");
    }

    public static function getBitrixVersion(): string
    {
        return SM_VERSION;
    }

    function pushClientReject(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://service.api.bus.skyweb24.ru/api/client/reject/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            "module_code"    => $this->MODULE_ID,
            "domain"         => $_SERVER['SERVER_NAME'],
            "php_version"    => \phpversion(),
            "bitrix_version" => SM_VERSION,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
    }

    function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
        $this->UninstallDB();
        Option::delete($this->MODULE_ID);
        $this->UninstallFiles();
        $this->UninstallAgents();
        $this->UninstallEvents();
    }
}

?>
