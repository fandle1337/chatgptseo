<?php

namespace Skyweb24\ChatgptSeo\Controller;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskDelete;

class ControllerTaskList extends ControllerAbstract
{
    public function deleteTaskAction(): bool
    {
        $taskId = $this->request->get('task_id');

        return ServiceLocator::getInstance()
            ->get(ServiceTaskDelete::class)
            ->deleteById(
                $taskId,
                [
                    'select' => ['*'],
                    'filter' => ['task_id' => $taskId],
                ],
            );
    }

}