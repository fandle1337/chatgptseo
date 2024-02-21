<?php

namespace Skyweb24\ChatgptSeo\Service;

use Skyweb24\ChatgptSeo\Dto\DtoTaskElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

class ServiceCheckElement
{
    public function __construct(
        protected RepositoryTaskElement $repositoryTaskElement
    )
    {
    }

    public function modifyElementList(array $elementIdList, int $taskId): array
    {
        if (!$taskId) {
            return $elementIdList;
        }

        $elementList = $this->repositoryTaskElement->getAllByTaskId($taskId);

        foreach ($elementIdList as $key => $elementId) {
            if ($this->isHasInTask($elementId, $elementList)) {
                unset($elementIdList[$key]);
            }
        }

        return array_values($elementIdList);
    }

    /**
     * @param int $elementId
     * @param DtoTaskElement[] $elementList
     * @return bool
     */
    protected function isHasInTask(int $elementId, array $elementList): bool
    {
        foreach ($elementList as $element) {
            if ($element->element_id == $elementId) {
                return true;
            }
        }

        return false;
    }
}
