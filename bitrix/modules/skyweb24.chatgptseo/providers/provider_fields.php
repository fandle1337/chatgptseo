<?php

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldElementType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldEntity;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldIncorrect;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldInput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldLanguage;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeArticle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeNews;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeProduct;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeService;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityDetailText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaTitle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityName;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityPreviewText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageEnglish;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageGerman;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageRussian;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeCreate;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeRewrite;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeTranslate;

return [
    FieldType::class             => [
        "className"         => FieldType::class,
        "constructorParams" => static function () {
            return [
                "operation_types",
                "types",
                [
                    ServiceLocator::getInstance()->get(TypeCreate::class),
                    ServiceLocator::getInstance()->get(TypeTranslate::class),
                    ServiceLocator::getInstance()->get(TypeRewrite::class),
                ],
            ];
        },
    ],
    FieldEntity::class           => [
        "className"         => FieldEntity::class,
        "constructorParams" => static function () {
            return [
                'entities',
                'entities',
                [
                    ServiceLocator::getInstance()->get(EntityName::class),
                    ServiceLocator::getInstance()->get(EntityPreviewText::class),
                    ServiceLocator::getInstance()->get(EntityDetailText::class),
                    ServiceLocator::getInstance()->get(EntityMetaTitle::class),
                    ServiceLocator::getInstance()->get(EntityMetaKeywords::class),
                    ServiceLocator::getInstance()->get(EntityMetaDescription::class),
                    ServiceLocator::getInstance()->get(EntityH1::class),
                ],
            ];
        },
    ],
    FieldElementType::class      => [
        "className"         => FieldElementType::class,
        "constructorParams" => static function () {
            return [
                'element_types',
                'element_types',
                [
                    ServiceLocator::getInstance()->get(ElementTypeArticle::class),
                    ServiceLocator::getInstance()->get(ElementTypeNews::class),
                    ServiceLocator::getInstance()->get(ElementTypeProduct::class),
                    ServiceLocator::getInstance()->get(ElementTypeService::class),
                ],
            ];
        },
    ],
    FieldIncorrect::class        => [
        "className"         => FieldIncorrect::class,
        "constructorParams" => static function () {
            return [
                'incorrect',
                'incorrect',
                [],
            ];
        },
    ],
    FieldLanguage::class         => [
        "className"         => FieldLanguage::class,
        "constructorParams" => static function () {
            return [
                'languages',
                'languages',
                [
                    ServiceLocator::getInstance()->get(LanguageRussian::class),
                    ServiceLocator::getInstance()->get(LanguageEnglish::class),
                    ServiceLocator::getInstance()->get(LanguageGerman::class),
                ],
            ];
        },
    ],
    FieldOutput::class           => [
        "className"         => FieldOutput::class,
        "constructorParams" => static function () {
            return [
                'output_fields',
                'output_fields',
                [],
            ];
        },
    ],
    FieldInput::class            => [
        "className"         => FieldInput::class,
        "constructorParams" => static function () {
            return [
                'input_fields',
                'input_fields',
                [],
            ];
        },
    ],
];