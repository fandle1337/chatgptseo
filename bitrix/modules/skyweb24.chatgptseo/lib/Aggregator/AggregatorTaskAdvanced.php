<?php

namespace Skyweb24\ChatgptSeo\Aggregator;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Web\Json;
use Skyweb24\ChatgptSeo\Dto\DtoTaskAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Model\ModelTasksTable;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class AggregatorTaskAdvanced
{
    public function __construct(
        protected RepositoryTask        $repositoryTask,
        protected RepositoryTaskElement $repositoryTaskElement
    )
    {
    }

    public function getById(int $taskId): DtoTaskAdvanced|false
    {
        if (!$dtoTask = $this->repositoryTask->getById($taskId)) {
            return false;
        }

        $dtoTaskAdvanced = new DtoTaskAdvanced(
            $dtoTask->id,
            $dtoTask->iblock_id,
            $dtoTask->date_create,
            $dtoTask->date_complete,
            $dtoTask->status_id,
            $dtoTask->operation_type,
            $dtoTask->element_type,
            $dtoTask->incorrect_text,
            $dtoTask->operations ? Json::decode($dtoTask->operations) : null,
        );

        $dtoTaskElementList = $this->repositoryTaskElement->getAllByTaskId($dtoTask->id);

        foreach ($dtoTaskElementList as $dtoTaskElement) {
            $dtoTaskAdvanced->elements[] = $dtoTaskElement;
        }

        return $dtoTaskAdvanced;
    }

    public function getInProgressTaskElementsById(int $taskId): DtoTaskAdvanced|false
    {
        if (!$dtoTask = $this->repositoryTask->getById($taskId)) {
            return false;
        }

        $dtoTaskAdvanced = new DtoTaskAdvanced(
            $dtoTask->id,
            $dtoTask->iblock_id,
            $dtoTask->date_create,
            $dtoTask->date_complete,
            $dtoTask->status_id,
            $dtoTask->operation_type,
            $dtoTask->element_type,
            $dtoTask->incorrect_text,
            $dtoTask->operations ? Json::decode($dtoTask->operations) : null,
        );

        $dtoTaskElementList = $this->repositoryTaskElement->getAllByTaskId($dtoTask->id);

        foreach ($dtoTaskElementList as $dtoTaskElement) {
            if ($dtoTaskElement->status_id == EnumStatus::PROGRESS) {
                $dtoTaskAdvanced->elements[] = $dtoTaskElement;
            }
        }

        return $dtoTaskAdvanced;
    }
}