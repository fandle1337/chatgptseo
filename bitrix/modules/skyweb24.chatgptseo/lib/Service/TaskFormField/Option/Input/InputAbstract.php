<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class InputAbstract extends OptionAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null
    ) {
        parent::__construct($name, $code);
    }

    abstract public function getDtoIblockElementValue(?DtoIblockElementAdvanced $dtoIblockElementAdvanced): ?string;
}
