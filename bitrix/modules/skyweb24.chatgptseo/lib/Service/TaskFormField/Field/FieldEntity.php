<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityDetailText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityName;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityMetaTitle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity\EntityPreviewText;

class FieldEntity extends FieldAbstract
{
    public function __construct(
        ?string $name = 'entities',
        ?string $code = 'entities',
    ) {
        parent::__construct($name, $code, [
            new EntityName(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_NAME")),
            new EntityPreviewText(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_PREVIEW_TEXT")),
            new EntityDetailText(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_DETAIL_TEXT")),
            new EntityMetaTitle(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_TITLE")),
            new EntityMetaKeywords(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_KEYWORDS")),
            new EntityMetaDescription(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_META_DESCRIPTION")),
            new EntityH1(Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_ENTITY_H1")),
        ]);
    }

    public function getValueForTemplate(mixed $value): string
    {
        $option = $this->getOptionByCode($value);
        return $option->getName();
    }

    public function getValueForTemplateOperation($optionCode)
    {
        return $this->getOptionByCode($optionCode)->getCode();
    }
}