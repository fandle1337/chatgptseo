<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateCreate;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateRewrite;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateTranslate;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationCreateExecute;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationRewriteExecute;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationTranslateExecute;
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
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureHtml;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature\FeatureSmile;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageEnglish;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageGerman;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language\LanguageRussian;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeCreate;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeRewrite;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeTranslate;

return [
    TypeCreate::class    => [
        "className"         => TypeCreate::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_CREATE"),
                "create",
                new TemplateCreate(
                    new RepositoryIblockProperty(),
                    ServiceLocator::getInstance()->get(ServiceParseIncorrectText::class)
                ),
                new StrategyOperationCreateExecute(
                    new RepositoryIblockProperty()
                ),
            ];
        },
    ],
    TypeTranslate::class => array(
        "className"         => TypeTranslate::class,
        "constructorParams" => static function () {
            return array(
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_TRANSLATE"),
                "translate",
                new TemplateTranslate(
                    new RepositoryIblockProperty(),
                    ServiceLocator::getInstance()->get(ServiceParseIncorrectText::class)
                ),
                new StrategyOperationTranslateExecute(
                    new RepositoryIblockProperty()
                ),
            );
        },
    ),
    TypeRewrite::class   => [
        "className"         => TypeRewrite::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_REWRITE"),
                "rewrite",
                new TemplateRewrite(
                    new RepositoryIblockProperty(),
                    ServiceLocator::getInstance()->get(ServiceParseIncorrectText::class)
                ),
                new StrategyOperationRewriteExecute(
                    new RepositoryIblockProperty()
                ),
            ];
        },
    ],

    EntityName::class            => [
        "className"         => EntityName::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_NAME"),
                "NAME",
                [
                    ServiceLocator::getInstance()->get(FeatureHtml::class),
                    ServiceLocator::getInstance()->get(FeatureSmile::class),
                ],
            ];
        },
    ],
    FeatureHtml::class           => [
        "className"         => FeatureHtml::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_HTML"),
                "html",
                [],
            ];
        },
    ],
    FeatureSmile::class          => [
        "className"         => FeatureSmile::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_FEATURE_SMILE"),
                "smile",
                [],
            ];
        },
    ],
    EntityMetaDescription::class => [
        "className"         => EntityMetaDescription::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_DESCRIPTION"),
                'ELEMENT_META_DESCRIPTION',
                [],
            ];
        },
    ],
    EntityMetaTitle::class       => [
        "className"         => EntityMetaTitle::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_TITLE"),
                'ELEMENT_META_TITLE',
                [],
            ];
        },
    ],
    EntityMetaKeywords::class    => [
        "className"         => EntityMetaKeywords::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_KEYWORDS"),
                'ELEMENT_META_KEYWORDS',
                [],
            ];
        },
    ],
    EntityH1::class              => [
        "className"         => EntityH1::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_H1"),
                'ELEMENT_PAGE_TITLE',
                [],
            ];
        },
    ],
    EntityPreviewText::class     => [
        "className"         => EntityPreviewText::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_PREVIEW_TEXT"),
                'PREVIEW_TEXT',
                [
                    ServiceLocator::getInstance()->get(FeatureHtml::class),
                    ServiceLocator::getInstance()->get(FeatureSmile::class),
                ],
            ];
        },
    ],
    EntityDetailText::class      => [
        "className"         => EntityDetailText::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_DETAIL_TEXT"),
                'DETAIL_TEXT',
                [
                    ServiceLocator::getInstance()->get(FeatureHtml::class),
                    ServiceLocator::getInstance()->get(FeatureSmile::class),
                ],
            ];
        },
    ],

    ElementTypeArticle::class => [
        "className"         => ElementTypeArticle::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_ARTICLE"),
                "article",
            ];
        },
    ],
    ElementTypeNews::class    => [
        "className"         => ElementTypeNews::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_NEWS"),
                "news",
            ];
        },
    ],
    ElementTypeProduct::class => [
        "className"         => ElementTypeProduct::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_PRODUCT"),
                "product",
            ];
        },
    ],
    ElementTypeService::class => [
        "className"         => ElementTypeService::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_SERVICE"),
                "service",
            ];
        },
    ],
    LanguageRussian::class    => [
        "className"         => LanguageRussian::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_RUSSIAN"),
                "russian",
            ];
        },
    ],
    LanguageEnglish::class    => [
        "className"         => LanguageEnglish::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_ENGLISH"),
                "english",
            ];
        },
    ],
    LanguageGerman::class     => [
        "className"         => LanguageGerman::class,
        "constructorParams" => static function () {
            return [
                Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LANGUAGE_GERMAN"),
                "german",
            ];
        },
    ],
];