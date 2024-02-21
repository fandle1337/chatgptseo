<?php

namespace Skyweb24\Chatgptseo\Controller\Index;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;

class ControllerTaskRestart
{
    public function index(int $taskId): void
    {
        $dtoTask = ServiceLocator::getInstance()
            ->get(RepositoryTask::class)
            ->getById($taskId);

        if (empty($dtoTask)) {
            LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_list.php');
        }

        $dtoTaskElementList = ServiceLocator::getInstance()
            ->get(RepositoryTaskElement::class)
            ->getAllWithErrorByTaskId(
                $dtoTask->id
            );

        ServiceLocator::getInstance()
            ->get(ServiceTaskUpdate::class)
            ->update(
                $dtoTask->id,
                ["status_id" => EnumStatus::READY_TO_WORK]
            );

        foreach ($dtoTaskElementList as $dtoTaskElement) {
            ServiceLocator::getInstance()->get(ServiceTaskElementUpdate::class)->update(
                $dtoTaskElement->id,
                ["status_id" => EnumStatus::READY_TO_WORK]
            );
        }

        LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $dtoTask->id);
    }
}
