<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputDetailText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputIblockProperty;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputName;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaTitle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputPreviewText;

class FieldOutput extends FieldAbstract
{
    public function __construct(
        ?string $name = "output_fields",
        ?string $code = "output_fields",
        ?array $optionList = []
    ) {
        parent::__construct($name, $code, $optionList);
    }
}