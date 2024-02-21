<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;

class InputIblockProperty extends InputAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null
    )
    {
        parent::__construct($name, $code);
    }

    public function getDtoIblockElementValue(?DtoIblockElementAdvanced $dtoIblockElementAdvanced): ?string
    {
        return $dtoIblockElementAdvanced->dtoIblockElement->propertyList[$this->code]['VALUE'];
    }
}