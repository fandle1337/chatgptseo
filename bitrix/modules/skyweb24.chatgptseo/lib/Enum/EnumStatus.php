<?php

namespace Skyweb24\ChatgptSeo\Enum;

use Bitrix\Main\Localization\Loc;

class EnumStatus
{
    const DONE = 1;
    const PROGRESS = 2;
    const DRAFT = 3;
    const ERROR = 4;
    const READY_TO_WORK = 5;

    public static function getLang($STATUS): ?string
    {
        return match ($STATUS) {
            self::DONE => Loc::getMessage("SKYWEB24_CHATGPTSEO_DONE"),
            self::PROGRESS => Loc::getMessage("SKYWEB24_CHATGPTSEO_IN_PROGRESS"),
            self::DRAFT => Loc::getMessage("SKYWEB24_CHATGPTSEO_DRAFT"),
            self::ERROR => Loc::getMessage("SKYWEB24_CHATGPTSEO_ERROR"),
            self::READY_TO_WORK => Loc::getMessage("SKYWEB24_CHATGPTSEO_READY_TO_WORK"),
        };
    }
}