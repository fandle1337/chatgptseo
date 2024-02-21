<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use \Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use Skyweb24\ChatGptSeo\Core\Informer;


$module_id = 'skyweb24.chatgptseo';
define("ADMIN_MODULE_NAME", $module_id);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$APPLICATION->SetTitle(Loc::getMessage("skyweb24.chatgptseo_PAGE_TITLE"));

CJSCore::Init(['skwb_base']);


Loader::IncludeModule($module_id);

Informer::createInfo($module_id);
?>

settings

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>