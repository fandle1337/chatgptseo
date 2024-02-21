<?php

namespace Skyweb24\ChatgptSeo\Aggregator;

use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElementSeoProperty;

class AggregatorIblockElementAdvanced
{
    public function __construct(
        protected RepositoryIblockElement            $repositoryElement,
        protected RepositoryIblockElementSeoProperty $repositoryIblockElementSeoProperty
    ) {
    }

    public function getById(int $id): ?DtoIblockElementAdvanced
    {
        if(!$dtoIblockElement = $this->repositoryElement->getById($id)) {
            return null;
        }

        $dtoIblockElementSeoProperty = $this->repositoryIblockElementSeoProperty->getById(
            $dtoIblockElement->iblockId,
            $dtoIblockElement->id
        );

        return new DtoIblockElementAdvanced(
            $dtoIblockElement,
            $dtoIblockElementSeoProperty
        );
    }
}