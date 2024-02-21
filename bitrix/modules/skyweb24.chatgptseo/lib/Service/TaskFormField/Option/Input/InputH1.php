<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;

class InputH1 extends InputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_PAGE_TITLE"
    ) {
        parent::__construct($name, $code);
    }

    public function getDtoIblockElementValue(?DtoIblockElementAdvanced $dtoIblockElementAdvanced): ?string
    {
        return $dtoIblockElementAdvanced->dtoIblockElementSeoProperty->h1;
    }
}