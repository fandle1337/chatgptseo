<?php

namespace Skyweb24\ChatgptSeo\Validator;

use Skyweb24\ChatgptSeo\Model\ModelTaskElementsTable;

class ValidatorTaskElement
{
    public function addTask(int $taskId, int $elementId): bool
    {
        $row = ModelTaskElementsTable::getList([
            'select' => ['*'],
            'filter' => [
                'task_id'    => $taskId,
                'element_id' => $elementId,
            ],
        ])->fetch();

        if ($row) {
            return true;
        } else {
            return false;
        }
    }
}