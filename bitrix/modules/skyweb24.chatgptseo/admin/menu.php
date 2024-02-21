<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$module_id = 'skyweb24.chatgptseo';

$aMenu = [
    "parent_menu" => "global_menu_services",
    "sort"        => 100,
    "url"         => "",
    "text"        => Loc::getMessage("skyweb24.chatgptseo_MENU_MAIN"),
    "title"       => Loc::getMessage("skyweb24.chatgptseo_MENU_MAIN"),
    "icon"        => "skyweb24_chatgptseo_menu_icon",
    "items_id"    => "skyweb24_chatgptseo",
    "items"       => [
        [
            "url"      => "skyweb24_chatgptseo_task_list.php?lang=" . LANGUAGE_ID,
            "title"    => Loc::getMessage("skyweb24.chatgptseo_TASK_LIST"),
            "text"     => Loc::getMessage("skyweb24.chatgptseo_TASK_LIST"),
            'more_url' => [
                'skyweb24_chatgptseo_task_edit.php'
            ],
        ],
        [
            "url"   => "settings.php?lang=" . LANGUAGE_ID . "&mid=" . $module_id,
            "title" => Loc::getMessage("skyweb24.chatgptseo_SETTINGS"),
            "text"  => Loc::getMessage("skyweb24.chatgptseo_SETTINGS"),
        ]
    ]
];

return $aMenu;
?>
