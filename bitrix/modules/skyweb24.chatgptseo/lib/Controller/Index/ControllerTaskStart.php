<?php

namespace Skyweb24\Chatgptseo\Controller\Index;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;
use Skyweb24\ChatgptSeo\Validator\ValidatorTask;

class ControllerTaskStart
{
    public function index(int $taskId)
    {
        if ((new ValidatorTask())->inWork($taskId)) {
            $dtoTaskAdvanced = ServiceLocator::getInstance()
                ->get(AggregatorTaskAdvanced::class)
                ->getById($taskId);

            if (
                $dtoTaskAdvanced->getStatusId() == EnumStatus::PROGRESS ||
                $dtoTaskAdvanced->getStatusId() == EnumStatus::DONE
            ) {
                return false;
            }

            $dtoTask = ServiceLocator::getInstance()
                ->get(RepositoryTask::class)
                ->getById($taskId);

            if (empty($dtoTask)) {
                LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_list.php');
            }

            $dtoTaskElementList = ServiceLocator::getInstance()
                ->get(RepositoryTaskElement::class)
                ->getAllByTaskId(
                    $dtoTask->id
                );

            foreach ($dtoTaskElementList as $dtoTaskElement) {
                ServiceLocator::getInstance()->get(ServiceTaskElementUpdate::class)->update(
                    $dtoTaskElement->id,
                    ["status_id" => EnumStatus::READY_TO_WORK]
                );
            }

            ServiceLocator::getInstance()
                ->get(ServiceTaskUpdate::class)
                ->update(
                    $dtoTask->id,
                    ["status_id" => EnumStatus::READY_TO_WORK]
                );

        }
        LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $taskId);
        return true;
    }
}