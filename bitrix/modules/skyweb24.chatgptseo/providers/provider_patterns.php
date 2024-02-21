<?php

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectType;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblock;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockSection;
use Skyweb24\ChatgptSeo\Repository\RepositoryPrice;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypeElement;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypeIblock;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypeParent;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypePrice;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type\PatternTypeProperty;

return [
    'pattern_list_related_class' => [
        "constructor" => static function () {
            return [
                EnumIncorrectType::PROPERTY->value => ServiceLocator::getInstance()->get(PatternTypeProperty::class),
                EnumIncorrectType::PARENT->value   => ServiceLocator::getInstance()->get(PatternTypeParent::class),
                EnumIncorrectType::IBLOCK->value   => ServiceLocator::getInstance()->get(PatternTypeIblock::class),
                EnumIncorrectType::PRICE->value    => ServiceLocator::getInstance()->get(PatternTypePrice::class),
                EnumIncorrectType::ELEMENT->value  => ServiceLocator::getInstance()->get(PatternTypeElement::class),
            ];
        },
    ],
    PatternTypeProperty::class => [
        "className"         => PatternTypeProperty::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    PatternTypeParent::class   => [
        "className"         => PatternTypeParent::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryIblockSection::class),
            ];
        },
    ],
    PatternTypeIblock::class   => [
        "className"         => PatternTypeIblock::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryIblock::class),
            ];
        },
    ],
    PatternTypePrice::class    => [
        "className"         => PatternTypePrice::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryPrice::class),
            ];
        },
    ],
    PatternTypeElement::class  => [
        "className"         => PatternTypeElement::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
];