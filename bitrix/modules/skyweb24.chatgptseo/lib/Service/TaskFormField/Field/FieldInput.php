<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputDetailText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputIblockProperty;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputName;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputMetaTitle;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\InputPreviewText;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

class FieldInput extends FieldAbstract
{
    public function __construct(
        ?string $name = "input_fields",
        ?string $code = "input_fields",
        ?array  $optionList = []
    ) {
        parent::__construct($name, $code, $optionList);
    }

    public function getOptionByCode(mixed $code): ?OptionAbstract
    {
        foreach ($this->optionList as $group) {
            foreach ($group->getOptionList() as $item) {
                if ($item->getCode() == $code) {
                    return $item;
                }
            }
        }
        return null;
    }
}