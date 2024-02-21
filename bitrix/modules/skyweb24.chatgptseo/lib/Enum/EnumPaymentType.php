<?php

namespace Skyweb24\ChatgptSeo\Enum;

use Bitrix\Main\Localization\Loc;

enum EnumPaymentType
{
    const TYPE_PREINSTALL = 'TYPE_PREINSTALL';
    const TYPE_PAYMENT = 'TYPE_PAYMENT';
    const TYPE_MANUAL = 'TYPE_MANUAL';

    public static function getLang($type): string
    {
        return match ($type) {
            self::TYPE_PREINSTALL => Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_TYPE_PREINSTALL'),
            self::TYPE_PAYMENT => Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_TYPE_PAYMENT'),
            self::TYPE_MANUAL => Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_TYPE_MANUAL'),
        };
    }
}
