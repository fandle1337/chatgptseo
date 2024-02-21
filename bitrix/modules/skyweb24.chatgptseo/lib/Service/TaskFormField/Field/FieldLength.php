<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Bitrix\Main\Localization\Loc;

class FieldLength extends FieldAbstract
{
    public function __construct(
        ?string $name = 'length',
        ?string $code = 'length',
        ?array $optionList = []
    ) {
        parent::__construct($name, $code, $optionList);
    }

    public function getValueForTemplate(mixed $value): string
    {
        $value .= ' '.Loc::getMessage("SKYWEB24_CHATGPTSEO_FIELD_LENGTH_SYMBOLS");
        return $value;
    }
}