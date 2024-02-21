<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Pattern\Type;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryPrice;

class PatternTypePrice extends PatternTypeAbstract
{
    public function __construct(
        protected RepositoryPrice  $repositoryPrice,

    )
    {
    }

    public function getValue(string $pattern, DtoIblockElementAdvanced $dto): string|false
    {
        if (!$priceId = $this->findCodeInPattern($pattern)) {
            return false;
        }

        if (!$price = $this->repositoryPrice->getPriceById($dto->dtoIblockElement->id, $priceId)) {
            return false;
        }

        return \CurrencyFormat($price['PRICE'], $price['CURRENCY']);
    }
}