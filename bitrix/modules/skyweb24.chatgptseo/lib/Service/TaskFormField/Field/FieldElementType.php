<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeArticle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeNews;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeProduct;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType\ElementTypeService;

class FieldElementType extends FieldAbstract
{
    public function __construct(
        ?string $name = "element_types",
        ?string $code = "element_types",
    ) {
        parent::__construct($name, $code, [
                new ElementTypeNews(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_NEWS")),
                new ElementTypeProduct(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_PRODUCT")),
                new ElementTypeArticle(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_ARTICLE")),
                new ElementTypeService(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ELEMENT_TYPE_SERVICE")),
            ]
        );
    }

}