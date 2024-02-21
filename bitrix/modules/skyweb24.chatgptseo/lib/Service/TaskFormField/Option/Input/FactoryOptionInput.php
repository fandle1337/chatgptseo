<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\OptionGroup\OptionGroup;

class FactoryOptionInput
{
    static public function make(array $propertyList): array
    {
        foreach ($propertyList as $property) {
            $iblockProperties[] = new InputIblockProperty($property['name'], $property['code']);
        }

        return [
            new OptionGroup(Loc::getMessage("SKYWEB24_CHATGPTSEO_GROUP_STANDARD"), 'standard', [
                new InputName(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_NAME')),
                new InputPreviewText(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_PREVIEW_TEXT')),
                new InputDetailText(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_DETAIL_TEXT')),
            ]),
            new OptionGroup(Loc::getMessage("SKYWEB24_CHATGPTSEO_GROUP_SEO"), 'SEO', [
                new InputMetaDescription(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_DESCRIPTION')),
                new InputMetaTitle(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_TITLE')),
                new InputMetaKeywords(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_KEYWORDS')),
                new InputH1(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_INPUT_H1")),
            ]),
            new OptionGroup(
                Loc::getMessage("SKYWEB24_CHATGPTSEO_GROUP_IBLOCK_PROPERTIES"),
                'iblockProperties',
                $iblockProperties ?? []
            ),

        ];
    }
}