<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageEnglish;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageGerman;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageRussian;

class FieldLanguage extends FieldAbstract
{
    public function __construct(
        ?string $name = "languages",
        ?string $code = "languages",
    ) {
        parent::__construct($name, $code, [
            new LanguageRussian(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_RUSSIAN")),
            new LanguageEnglish(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_ENGLISH")),
            new LanguageGerman(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_GERMAN")),
        ]);
    }
}