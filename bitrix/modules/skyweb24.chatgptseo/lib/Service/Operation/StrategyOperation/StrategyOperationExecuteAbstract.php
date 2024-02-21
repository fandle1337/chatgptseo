<?php

namespace Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation;

use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;

abstract class StrategyOperationExecuteAbstract
{
    public function __construct(
        protected RepositoryIblockProperty $repositoryIblockProperty
    )
    {
    }

    abstract public function make(array $chatGptAnswer, array $operation, int $iblockId): array;

    public function getPropertyList(int $iblockId): array
    {
        return $this->repositoryIblockProperty->getById($iblockId, ["S"]);
    }
}