<?php

namespace Skyweb24\ChatgptSeo\Service\Operation;

use Skyweb24\ChatgptSeo\Dto\DtoTaskAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationExecuteAbstract;

class TaskOperationExecute
{
    public function __construct(
        protected StrategyOperationExecuteAbstract $strategy,
        protected RepositoryIblockElement          $repository,
        protected RepositoryIblockProperty         $repositoryIblockProperty,
    )
    {
    }

    public function make(DtoTaskAdvanced $dtoTaskAdvanced, array $chatGptAnswer, int $elementId): bool
    {
        foreach ($dtoTaskAdvanced->operations as $operation) {
    //TODO рефактор, при обновлении свойств инфоблока обычным CIBockElement->update все свойства стирались, кроме последнего
    // сделали так, что если приходит массив из свойств инфоблока, он обрабатывается методом из RepositoryIblockProperty
    // нужно, чтобы  метод make просто обновлял поля по приходящей вместе с данными стратегией $fieldOption

            $dataUpdate = $this->strategy->make($chatGptAnswer, $operation, $dtoTaskAdvanced->iblock_id);
            if (isset($dataUpdate['PROPERTY_VALUES'])) {
                $this->repositoryIblockProperty->update($elementId, $dataUpdate['PROPERTY_VALUES']);
            } else {
                $this->repository->update($elementId, $dataUpdate);
            }
        }
        return true;
    }
}