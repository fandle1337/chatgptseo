<?php

namespace Skyweb24\ChatgptSeo\Service\Statistics\Fill;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryUser;

class ServiceFillDate extends ServiceFillAbstract
{
    public function __construct(
        protected RepositoryTask $repositoryTask,
        protected RepositoryUser $repositoryUser,
    )
    {
    }

    public function fillDates(array $taskList): array
    {
        $taskIdList = $this->getTaskIdList($taskList);

        $taskListFromTable = $this->repositoryTask->getByIdList($taskIdList);

        return $this->mapDateByTaskIdList($taskList, $taskListFromTable);
    }

    protected function mapDateByTaskIdList(array $taskList, array $taskListFromTable): array
    {
        foreach ($taskList as &$task) {
            foreach ($taskListFromTable as $taskFromTable) {
                if ($taskFromTable->id == $task['task_id']) {
                    $task['date'] = MakeTimeStamp($taskFromTable->date_complete, "DD.MM.YYYY") * 1000;
                }
            }
        }

        return $taskList;
    }
}