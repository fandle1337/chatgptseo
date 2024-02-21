<?php

namespace Skyweb24\ChatgptSeo\Controller;

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementDelete;

class ControllerTaskEdit extends ControllerAbstract
{
    public function deleteElementAction(): bool
    {
        $elementId = $this->request->get('element_id');

        return  ServiceLocator::getInstance()
            ->get(ServiceTaskElementDelete::class)
            ->deleteById($elementId);
    }

}