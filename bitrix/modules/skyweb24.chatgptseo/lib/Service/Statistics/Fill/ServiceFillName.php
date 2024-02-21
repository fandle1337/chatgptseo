<?php

namespace Skyweb24\ChatgptSeo\Service\Statistics\Fill;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryUser;

class ServiceFillName extends ServiceFillAbstract
{
    public function __construct(
        protected RepositoryTask $repositoryTask,
        protected RepositoryUser $repositoryUser,
    )
    {
    }

    public function fillNames(?array $taskList): array
    {
        if (!$taskList) {
            return [];
        }

        $taskIdList = $this->getTaskIdList($taskList);

        $tasks = $this->repositoryTask->getByIdList($taskIdList);

        $userIdList = $this->getUserListId($tasks);

        $users = $this->repositoryUser->getUserNamesByIdList($userIdList);

        return $this->mapUserNamesByTaskList($taskList, $userIdList, $users);

    }
    protected function mapUserNamesByTaskList(array $taskList, array $userIdList, array $users): array
    {
        foreach ($taskList as &$taskStat) {
            foreach ($userIdList as $taskId => $userId) {
                if ($taskStat['task_id'] == $taskId) {
                    foreach ($users as $user => $name) {
                        if ($userId == $user) {
                            $taskStat['name'] = $name;
                        }
                    }
                }
            }
        }
        return $taskList;
    }

    protected function getUserListId(array $tasks): array
    {
        foreach ($tasks as $task) {
            $userIdList[$task->id] = $task->user_id;
        }

        return $userIdList ?? [];
    }
}