<?php

namespace Skyweb24\ChatgptSeo\Service;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class ServiceCheckIblock
{
    public function __construct(
        protected RepositoryTaskElement $repositoryTaskElement,
        protected RepositoryTask        $repositoryTask,
    )
    {
    }

    public function checkIblock(int $iblockId, ?int $taskId): bool
    {
        if (!$taskId) {
            return true;
        }

        $dtoTask = $this->repositoryTask->getById($taskId);

        if ($this->repositoryTaskElement->getCountByTaskId($taskId) > 0) {
            if ($iblockId == $dtoTask->iblock_id) {
                return true;
            }
            return false;
        } else {
            $this->repositoryTask->update($taskId, ['iblock_id' => $iblockId]);
            return true;
        }
    }
}
