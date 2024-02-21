<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;

class InputMetaKeywords extends InputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_META_KEYWORDS"
    ) {
        parent::__construct($name, $code);
    }

    public function getDtoIblockElementValue(?DtoIblockElementAdvanced $dtoIblockElementAdvanced): ?string
    {
        return $dtoIblockElementAdvanced->dtoIblockElementSeoProperty->keywords;
    }
}