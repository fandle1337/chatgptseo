<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectType;

abstract class PatternTypeAbstract
{
    abstract public function getValue(string $pattern, DtoIblockElementAdvanced $dto): string|false;

    protected function findCodeInPattern(string $pattern): string|false
    {
        $patternTypeList = implode('|', array_column(EnumIncorrectType::cases(), "value"));
        preg_match_all('/{(' . $patternTypeList . ')\.([\dA-Za-z_]+)}/', $pattern, $matches);

        if (!empty($matches[2][0])) {
            return $matches[2][0];
        }

        return false;
    }
}