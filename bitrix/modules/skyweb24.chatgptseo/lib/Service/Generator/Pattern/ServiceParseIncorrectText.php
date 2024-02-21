<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectType;

class ServiceParseIncorrectText
{
    public function getResult(string $text, DtoIblockElementAdvanced $dto): string|bool
    {
        if (!$patternList = $this->searchPatterns($text)) {
            return false;
        }

        if (!$patternValueList = $this->extractValueByPatternList($patternList, $dto)) {
            return false;
        }

        return $this->replacePatterns($text, $patternValueList);
    }

    protected function searchPatterns(string $text): array|bool
    {
        $patternTypeList = implode('|', array_column(EnumIncorrectType::cases(), "value"));
        preg_match_all('/{(' . $patternTypeList . ')\.([\dA-Za-z_]+)}/', $text, $matches);

        return array_unique($matches[0]) ?? false;
    }

    protected function extractValueByPatternList(array $patterns, DtoIblockElementAdvanced $dto): array
    {
        foreach ($patterns as $pattern) {
            $rows[$pattern] = $this->extractValueByPattern($pattern, $dto);
        }

        return $rows ?? [];
    }

    protected function extractValueByPattern(string $pattern, DtoIblockElementAdvanced $dto): string|false
    {
        if (!$servicePatternType = FactoryPatternType::makeByCode($this->findTypeInPattern($pattern))) {
            return false;
        }
        return $servicePatternType->getValue($pattern, $dto);
    }

    protected function findTypeInPattern(string $pattern): string|false
    {
        $patternTypeList = implode('|', array_column(EnumIncorrectType::cases(), "value"));
        preg_match_all('/{(' . $patternTypeList . ')\.([\dA-Za-z_]+)}/', $pattern, $matches);

        if (!empty($matches[1][0])) {
            return $matches[1][0];
        }

        return false;
    }

    protected function replacePatterns(string $text, array $patternValueList): string
    {
        foreach ($patternValueList as $pattern => $value) {
            $text = str_replace(
                $pattern,
                $value ?: Loc::getMessage('SKYWEB24_CHATGPTSEO_PARSE_INCORRECT_TEXT_NO_INFO'),
                $text
            );
        }

        return $text;
    }
}
