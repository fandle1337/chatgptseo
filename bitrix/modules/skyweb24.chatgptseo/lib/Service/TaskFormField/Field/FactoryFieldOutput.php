<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputDetailText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputIblockProperty;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaTitle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputName;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputPreviewText;

class FactoryFieldOutput
{
    static public function make(array $propertyList): FieldOutput
    {
        $optionList = [
            new OutputName(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_NAME')),
            new OutputPreviewText(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_PREVIEW_TEXT')),
            new OutputDetailText(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_DETAIL_TEXT')),
            new OutputMetaDescription(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_DESCRIPTION')),
            new OutputMetaTitle(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_TITLE')),
            new OutputMetaKeywords(Loc::getMessage('SKYWEB24_CHATGPTSEO_FIELD_INPUT_META_KEYWORDS')),
            new OutputH1(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_INPUT_H1")),
        ];

        foreach ($propertyList as $property) {
            $optionList[] = new OutputIblockProperty($property['name'], $property['code']);
        }

        return new FieldOutput("output_fields", "output_fields", $optionList);
    }
}