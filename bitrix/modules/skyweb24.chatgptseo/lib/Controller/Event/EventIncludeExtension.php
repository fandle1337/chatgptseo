<?php

namespace Skyweb24\Chatgptseo\Controller\Event;

use Bitrix\Main\Loader;
use CJSCore;

class EventIncludeExtension
{
    public static function OnEpilog()
    {
        if (
            $GLOBALS["APPLICATION"]->GetCurPage() == "/bitrix/admin/iblock_element_edit.php" ||
            $GLOBALS["APPLICATION"]->GetCurPage() == "/bitrix/admin/iblock_element_admin.php" ||
            $GLOBALS["APPLICATION"]->GetCurPage() == "/bitrix/admin/iblock_list_admin.php"
        ) {
            Loader::includeModule("skyweb24.chatgptseo");
            CJSCore::Init(["skyweb24.chatgptseo"]);
        }
    }
}