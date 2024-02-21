<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Incorrect;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectCode;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\OptionGroup\OptionGroup;

class FactoryIncorrectOption
{
    public static function make(array $propertyList, ?array $priceList): array
    {

        if ($priceList) {
            foreach ($priceList as $price) {
                $prices[] = new IncorrectPattern($price['NAME'], $price['ID']);
            }
        }

        foreach ($propertyList as $property) {
            $iblockProperties[] = new IncorrectPattern($property['name'], $property['code']);
        }

        return [
            new OptionGroup(
                Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_GROUP_ELEMENT'),
                EnumIncorrectType::ELEMENT->value,
                [
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_ELEMENT_TITLE'),
                        EnumIncorrectCode::NAME->name
                    ),
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_ELEMENT_PREVIEW_TEXT'),
                        EnumIncorrectCode::PREVIEW_TEXT->name
                    ),
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_ELEMENT_DETAIL_TEXT'),
                        EnumIncorrectCode::DETAIL_TEXT->name
                    ),
                ]
            ),
            new OptionGroup(
                Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_GROUP_PROPERTY'),
                EnumIncorrectType::PROPERTY->value,
                $iblockProperties ?? []
            ),
            new OptionGroup(
                Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_GROUP_PARENT'),
                EnumIncorrectType::PARENT->value,
                [
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_PARENT_TITLE'),
                        EnumIncorrectCode::TITLE->name
                    ),
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_PARENT_DESCRIPTION'),
                        EnumIncorrectCode::DESCRIPTION->name
                    ),
                ],
            ),
            new OptionGroup(
                Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_GROUP_IBLOCK'),
                EnumIncorrectType::IBLOCK->value,
                [
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_IBLOCK_TITLE'),
                        EnumIncorrectCode::TITLE->name
                    ),
                    new IncorrectPattern(
                        Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_IBLOCK_DESCRIPTION'),
                        EnumIncorrectCode::DESCRIPTION->name
                    ),
                ],
            ),
            new OptionGroup(
                Loc::getMessage('SKYWEB24_CHATGPTSEO_INCORRECT_OPTION_GROUP_PRICE'),
                EnumIncorrectType::PRICE->value,
                $priceList ? $prices ?? [] : [],
            )
        ];
    }
}