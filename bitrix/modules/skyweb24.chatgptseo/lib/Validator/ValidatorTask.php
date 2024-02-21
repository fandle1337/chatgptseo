<?php

namespace Skyweb24\ChatgptSeo\Validator;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Model\ModelTasksTable;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;

class ValidatorTask
{
    public function inWork(int $taskId): bool
    {
        $row = ServiceLocator::getInstance()->get(RepositoryTask::class)->getById($taskId);

        if (
            $row->operation_type == null ||
            $row->element_type == null ||
            $row->operations == null
        ) {
            return false;
        } else {
            return true;
        }
    }
}