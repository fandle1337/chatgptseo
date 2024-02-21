<?php

namespace Skyweb24\ChatgptSeo\Service\Statistics\Fill;

abstract class ServiceFillAbstract
{
    protected function getTaskIdList(array $taskList): array
    {
        foreach ($taskList as $taskStat) {
            $taskIdList[] = $taskStat['task_id'];
        }

        return $taskIdList ?? [];
    }
}