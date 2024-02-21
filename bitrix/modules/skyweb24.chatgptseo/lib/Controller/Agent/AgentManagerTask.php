<?php

namespace Skyweb24\ChatgptSeo\Controller\Agent;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use CAgent;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryAgent;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;

Loader::IncludeModule('skyweb24.chatgptseo');

class AgentManagerTask
{
    /**
     * @throws \Bitrix\Main\LoaderException
     */
    public static function handle(): string
    {
        if (ServiceLocator::getInstance()->get(RepositoryAgent::class)->isActiveAgentTaskExecute()) {

            return '\Skyweb24\ChatgptSeo\Controller\Agent\AgentManagerTask::handle();';
        }

        $tasks = ServiceLocator::getInstance()
            ->get(RepositoryTask::class)
            ->getAllByStatus(EnumStatus::READY_TO_WORK);

        if (isset($tasks[0]['id'])) {

            CAgent::AddAgent(
                '\Skyweb24\ChatgptSeo\Controller\Agent\AgentTaskExecute::execute(' . $tasks[0]['id'] . ');',
                'skyweb24.chatgptseo',
                'N',
                60,
                '',
                'Y',
                new DateTime(),
            );

            ServiceLocator::getInstance()
                ->get(ServiceTaskUpdate::class)
                ->update(
                    $tasks[0]['id'],
                    ["status_id" => EnumStatus::PROGRESS]
                );

            $dtoTaskElementList = ServiceLocator::getInstance()
                ->get(RepositoryTaskElement::class)
                ->getAllReadyToWorkByTaskId(
                    $tasks[0]['id']
                );

            foreach ($dtoTaskElementList as $dtoTaskElement) {
                ServiceLocator::getInstance()
                    ->get(ServiceTaskElementUpdate::class)
                    ->update(
                        $dtoTaskElement->id,
                        ["status_id" => EnumStatus::PROGRESS]
                    );
            }
        }

        return '\Skyweb24\ChatgptSeo\Controller\Agent\AgentManagerTask::handle();';
    }
}

