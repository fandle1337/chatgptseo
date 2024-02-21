<?php

namespace Skyweb24\ChatgptSeo\Service\Task;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;

class ServiceTaskUpdate
{
    public function __construct(protected RepositoryTask $repositoryTask)
    {
    }

    public function update(int $taskId, array $data): bool
    {
        if ($this->repositoryTask->update($taskId, $data)) {
            return true;
        } else {
            return false;
        }
    }
}
