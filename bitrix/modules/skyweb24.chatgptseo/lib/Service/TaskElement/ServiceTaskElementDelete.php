<?php

namespace Skyweb24\ChatgptSeo\Service\TaskElement;

use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class ServiceTaskElementDelete
{
    public function __construct(

        protected RepositoryTaskElement $repositoryTaskElement,
    )
    {
    }

    public function deleteById(int $taskElementId): bool
    {
        if ($this->repositoryTaskElement->delete($taskElementId)->isSuccess()) {
            return true;
        }
        return false;
    }

    public function massDeleteById(array $listElementId): void
    {
        foreach ($listElementId as $elementId) {
            $this->deleteById($elementId);
        }
    }

    public function deleteAllByTaskId(int $taskId): void
    {
        $listTaskElementId = $this->repositoryTaskElement->getListElementIdByTaskId($taskId);
        foreach ($listTaskElementId as $taskElementId) {
            $this->massDeleteById($taskElementId);
        }
    }
}