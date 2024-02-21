<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;

class InputDetailText extends InputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "DETAIL_TEXT"
    ) {
        parent::__construct($name, $code);
    }

    public function getDtoIblockElementValue(?DtoIblockElementAdvanced $dtoIblockElementAdvanced): ?string
    {
        return $dtoIblockElementAdvanced->dtoIblockElement->detailText;
    }
}