<?php

namespace Skyweb24\ChatgptSeo\Service\TaskElement;

use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class ServiceTaskElementUpdate
{
    public function __construct(protected RepositoryTaskElement $repositoryTaskElement)
    {
    }

    public function update(int $elementId, array $data): bool
    {
        if ($this->repositoryTaskElement->update($elementId, $data)) {
            return true;
        }
        return false;
    }
}
