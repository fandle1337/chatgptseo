<?php

namespace Skyweb24\ChatgptSeo\Service\Task;

use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class ServiceTaskDelete
{
    public function __construct(protected RepositoryTask        $repositoryTask,
                                protected RepositoryTaskElement $repositoryTaskElement
    )
    {
    }

    public function deleteById(int $taskId, array $data): bool
    {
        if ($this->repositoryTask->delete($taskId)) {
            $elementList = $this->repositoryTaskElement->getElementList($data);
            if ($elementList) {
                foreach ($elementList as $element) {
                    $this->repositoryTaskElement->delete($element['id']);
                }
            }
            return true;
        }
        return false;
    }
}