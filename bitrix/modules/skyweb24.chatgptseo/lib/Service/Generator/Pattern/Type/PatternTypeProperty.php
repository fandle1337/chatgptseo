<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;

class PatternTypeProperty extends PatternTypeAbstract
{
    public function getValue(string $pattern, DtoIblockElementAdvanced $dto): false|string
    {
        return $dto->dtoIblockElement->propertyList[$this->findCodeInPattern($pattern)]['VALUE'] ?: false;
    }
}