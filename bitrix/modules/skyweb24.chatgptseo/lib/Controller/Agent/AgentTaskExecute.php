<?php

namespace Skyweb24\ChatgptSeo\Controller\Agent;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Type\DateTime;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumOptionTask;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositorySetting;
use Skyweb24\ChatgptSeo\Service\ServiceTaskOperationManager;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;

class AgentTaskExecute
{
    /**
     * @var mixed|RepositorySetting
     */
    protected static mixed $repositorySetting;

    /**
     * @throws \Exception
     */
    public static function execute(int $taskId)
    {
        self::$repositorySetting = ServiceLocator::getInstance()->get(RepositorySetting::class);

        if (self::isCheckWorking($taskId)) {
            return;
        }

        self::$repositorySetting->setValue(EnumOptionTask::timestampStart($taskId), (string)time());
        self::$repositorySetting->setValue(EnumOptionTask::isWorking($taskId), 'Y');

        $dtoTaskAdvanced = ServiceLocator::getInstance()
            ->get(AggregatorTaskAdvanced::class)
            ->getInProgressTaskElementsById($taskId);

        ServiceLocator::getInstance()->get(ServiceTaskOperationManager::class)
            ->makeAll($dtoTaskAdvanced);

        ServiceLocator::getInstance()->get(ServiceTaskUpdate::class)->update(
            $taskId,
            [
                'date_complete' => new DateTime(),
                'status_id'     => EnumStatus::DONE,
            ]
        );

        self::$repositorySetting->setValue(EnumOptionTask::isWorking($taskId), "N");
    }

    public static function isCheckWorking($taskId): bool
    {
        $optionIsWorking = self::$repositorySetting->getValue(EnumOptionTask::isWorking($taskId));

        if (empty($optionIsWorking)) {
            return false;
        }

        if ($optionIsWorking === 'N') {
            return false;
        }

        if ($optionIsWorking === "Y") {
            $optionTimestampStart = self::$repositorySetting
                    ->getValue(EnumOptionTask::timestampStart($taskId)) ?? 0;

            if (time() - $optionTimestampStart >= 3600) {
                self::$repositorySetting->setValue(EnumOptionTask::isWorking($taskId), 'N');
                return false;
            }
        }

        return true;
    }
}