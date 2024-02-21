<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Loader;
use Skyweb24\ChatgptSeo\Dto\DtoTask;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblock;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Service\ServiceCheckElement;
use Skyweb24\ChatgptSeo\Service\ServiceCheckIblock;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskCreate;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskDelete;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementCreate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementDelete;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;
use Skyweb24\ChatgptSeo\Validator\ValidatorTask;
use Bitrix\Main\Type\DateTime;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$module_id = 'skyweb24.chatgptseo';
Loader::IncludeModule($module_id);

if ($_REQUEST['action'] == 'create_elements') {
    if (is_array($_REQUEST['id'])) {
        foreach ($_REQUEST['id'] as $item) {
            $elementsId[] = $item;
        }
    } else {
        $elementsId[] = $_REQUEST['id'];
    }
    $taskId = ServiceLocator::getInstance()
        ->get(ServiceTaskElementCreate::class)
        ->addNewElementsFromIBlock($elementsId ?? []);
    LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $taskId);
}

// start generation
if ($_REQUEST['action'] == 'start') {
    (new \Skyweb24\Chatgptseo\Controller\Index\ControllerTaskStart())->index($_REQUEST['id']);
}

// create new clean task
if ($_REQUEST['action'] == 'createTask') {
    $taskId = ServiceLocator::getInstance()
        ->get(ServiceTaskCreate::class)
        ->create([
            'user_id'        => $USER->GetID(),
            'date_create'    => new DateTime(),
            'status_id'      => '3',
            'iblock_id'      => (new RepositoryIblock())->getIdDefaultIblock(),
            'incorrect_text' => '',
        ]);
    LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $taskId);
}

if ($_REQUEST['action'] == 'task_restart') {
    (new \Skyweb24\Chatgptseo\Controller\Index\ControllerTaskRestart())->index($_REQUEST['id']);
}

if ($_REQUEST['action'] == 'create_task_on') {
    /** @var DtoTask $dtoTask */
    $dtoTask = ServiceLocator::getInstance()->get(RepositoryTask::class)
        ->getById($_REQUEST['id']);
    $createdTaskId = ServiceLocator::getInstance()
        ->get(ServiceTaskCreate::class)
        ->create([
            'user_id'        => $USER->GetID(),
            'date_create'    => new DateTime(),
            'status_id'      => '3',
            'iblock_id'      => $dtoTask->iblock_id,
            'operation_type' => $dtoTask->operation_type,
            'element_type'   => $dtoTask->element_type,
            'incorrect_text' => $dtoTask->incorrect_text,
            'operations'     => $dtoTask->operations,

        ]);
    LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $createdTaskId);
}

if ($_REQUEST['action'] == 'add_elements_to') {

    foreach ($_REQUEST['element_id'] as $elementId) {
        $elementIdList[] = $elementId;
    }

    $taskId = (int)$_REQUEST['task_id'];
    $iblockId = (int)$_REQUEST['iblock_id'];

    $modifiedElementList = ServiceLocator::getInstance()
        ->get(ServiceCheckElement::class)
        ->modifyElementList($elementIdList ?? [], $taskId);

    if (!$taskId) {
        $taskId = ServiceLocator::getInstance()
            ->get(ServiceTaskElementCreate::class)
            ->addNewElementsFromIBlock($elementIdList ?? []);
        LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $taskId);
    }

    if (ServiceLocator::getInstance()->get(ServiceCheckIblock::class)->checkIblock($iblockId, $taskId)) {
        ServiceLocator::getInstance()
            ->get(ServiceTaskElementCreate::class)
            ->addElementListByTaskId($modifiedElementList, $taskId);
    }


    LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $taskId);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>