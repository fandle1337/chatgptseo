<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateCreate;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateRewrite;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateTranslate;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeCreate;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeRewrite;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type\TypeTranslate;

class FieldType extends FieldAbstract
{
    public function __construct(
        ?string $name = "operation_types",
        ?string $code = "types",
        ?array $optionList = []
    )
    {
        parent::__construct($name, $code, [
            new TypeCreate(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_CREATE")),
            new TypeRewrite(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_REWRITE")),
            new TypeTranslate(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_TYPE_TRANSLATE"))
        ]);
    }
}