<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumIncorrectCode;

class PatternTypeElement extends PatternTypeAbstract
{
    public function getValue(string $pattern, DtoIblockElementAdvanced $dto): false|string
    {
        $code = $this->findCodeInPattern($pattern);

        return match ($code) {
            EnumIncorrectCode::NAME->name => $dto->dtoIblockElement->name,
            EnumIncorrectCode::PREVIEW_TEXT->name => $dto->dtoIblockElement->previewText,
            EnumIncorrectCode::DETAIL_TEXT->name => $dto->dtoIblockElement->detailText,
            default => false,
        };
    }
}