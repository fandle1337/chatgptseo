<?php

namespace Skyweb24\ChatgptSeo\Service\Task;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;

class ServiceTaskCreate
{

    public function __construct(protected RepositoryTask $repositoryTask)
    {
    }

    public function create(array $data): ?int
    {
        $result = $this->repositoryTask->add($data);
        if ($result->isSuccess())
        {
            return $result->getId();
        } else {
            return null;
        }
    }
}