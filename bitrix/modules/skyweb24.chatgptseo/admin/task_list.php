<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Grid\Panel\Snippet;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\Grid\Options;
use Bitrix\Main\UI\PageNavigation;
use Skyweb24\ChatGptSeo\Core\Informer;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryUser;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskDelete;


$module_id = 'skyweb24.chatgptseo';
define("ADMIN_MODULE_NAME", $module_id);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$APPLICATION->SetTitle(Loc::getMessage("SKYWEB24_CHATGPTSEO_TASK_LIST"));

Loader::IncludeModule($module_id);
CJSCore::Init(["skyweb24.chatgptseo"]);
 
Informer::createInfo($module_id);

$table = ServiceLocator::getInstance()->get(RepositoryTask::class);
$elementTable = ServiceLocator::getInstance()->get(RepositoryTaskElement::class);
$snippets = new Snippet();
$status = new EnumStatus();

if ($_REQUEST['action_button_tasks'] == 'delete') {
    foreach ($_REQUEST['ID'] as $taskId) {
        ServiceLocator::getInstance()->get(ServiceTaskDelete::class)->deleteById(
            $taskId,
            [
                'select' => ['*'],
                'filter' => ['task_id' => $taskId],
            ]
        );
    }
} ?>
<div class="adm-toolbar-panel-container toolbar_sale_years">
    <div class="adm-toolbar-panel-flexible-space">
        <?php $gridId = 'tasks';
        $gridOptions = new Options($gridId);

        $sort = $gridOptions->GetSorting([
            'sort' => ['id' => 'asc'],
            'vars' => ['by' => 'by', 'order' => 'order']
        ]);

        $navOption = $gridOptions->GetNavParams();

        $pageSizes = [
            ['NAME' => "5", 'VALUE' => '5'],
            ['NAME' => '10', 'VALUE' => '10'],
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
            ['NAME' => '100', 'VALUE' => '100']
        ];

        $nav = new PageNavigation($gridId);
        $nav->allowAllRecords(false)
            ->setPageSize($navOption['nPageSize'])
            ->initFromUri();

        $filterFields = [
            ['id'     => 'status_id', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_STATUS"),
             'type'   => 'list',
             'items'  => [
                 '1' => EnumStatus::getLang(EnumStatus::DONE),
                 '2' => EnumStatus::getLang(EnumStatus::PROGRESS),
                 '3' => EnumStatus::getLang(EnumStatus::DRAFT),
                 '4' => EnumStatus::getLang(EnumStatus::ERROR),
             ],
             'params' => ['multiple' => 'Y']
            ]
        ];

        $APPLICATION->IncludeComponent(
            'bitrix:main.ui.filter',
            '',
            [
                'FILTER_ID'          => 'task_filter',
                'GRID_ID'            => 'tasks',
                'FILTER'             => $filterFields,
                'ENABLE_LIVE_SEARCH' => true,
                'ENABLE_LABEL'       => true
            ]
        );
        $filter = CUserOptions::GetOption('main.ui.filter', 'task_filter')["filters"]['tmp_filter']['fields'];
        $result = $table->getAll(
            $filter,
            $nav->getOffset(),
            $nav->getLimit(),
            $sort['sort'],
        );
        $nav->setRecordCount($result->getCount());

        $result = $result->fetchAll();

        ?>
    </div>
    <div class="adm-toolbar-panel-align-right">
        <button class="ui-btn ui-btn-icon-add ui-btn-primary"
                onclick="location.href='/bitrix/admin/skyweb24_chatgptseo_task_action.php?action=createTask'">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_ADD_BUTTON") ?>
        </button>
    </div>
</div>
<script>
    function confirmDelete(taskId) {
        if (confirm(BX.message('SKYWEB24_CHATGPTSEO_TASK_CONFIRM_DELETE'))) {
            BX.ajax.runAction('skyweb24:chatgptseo.api.ControllerTaskList.deleteTask', {
                data: {
                    task_id: taskId,
                }
            })
                .then(e => {
                    if (e.data) {
                        BX.Main.gridManager.reload('tasks')
                    }
                })
        }
    }
</script>
<?php
$columns = [
    ['id' => 'id', 'name' => 'ID', 'sort' => 'id', 'default' => true],
    ['id' => 'user_id', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_USER"), 'sort' => 'user_id', 'default' => true],
    ['id' => 'date_create', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_DATE_CREATE"), 'sort' => 'date_create', 'default' => true],
    ['id' => 'date_complete', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_DATE_COMPLETE"), 'sort' => 'date_complete', 'default' => true],
    ['id' => 'status_id', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_STATUS"), 'sort' => 'status_id', 'default' => true],
    ['id' => 'count', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_ELEMENTS_COUNT"), 'default' => true],
];

foreach ($result as $item) {
    $rows[] = [
        'id'      => $item['id'],
        'data'    => [
            'id'            => '<a href="/bitrix/admin/skyweb24_chatgptseo_task_edit.php?lang=ru&id=' . $item['id'] . '">' . $item['id'] . '</a>',
            'user_id'       => '<a target="_blank" href="/bitrix/admin/user_edit.php?lang=' . LANGUAGE_ID . '&ID=' . $item['user_id'] . '">'
                . ServiceLocator::getInstance()->get(RepositoryUser::class)->getUserNameById($item['user_id']) . '</a>',
            'date_create'   => $item['date_create'],
            'date_complete' => $item['date_complete'],
            'status_id'     => $status->getLang((int)$item['status_id']),
            'count'         => $elementTable->countDoneElements($item['id']) . '/' . $elementTable->countTotalElements($item['id']),
        ],
        'actions' => [
            [
                'text'    => Loc::getMessage("SKYWEB24_CHATGPTSEO_EDIT"),
                'href'    => '/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $item['id'],
                'default' => true,
            ],
            [
                'text' => Loc::getMessage('SKYWEB24_CHATGPTSEO_CREATE'),
                'href' => '/bitrix/admin/skyweb24_chatgptseo_task_action.php?action=create_task_on&id=' . $item['id'],
            ],
            [
                'text' => Loc::getMessage("SKYWEB24_CHATGPTSEO_DELETE"),
                'onclick' => 'confirmDelete(' . $item['id'] . ')',
            ]
        ],
    ];
}

$APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID'    => $gridId,
        'COLUMNS'    => $columns,
        'ROWS'       => $rows ?? [],
        'NAV_OBJECT' => $nav,
        'PAGE_SIZES' => $pageSizes,

        'AJAX_MODE'           => 'Y',
        'AJAX_ID'             => CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
        'AJAX_OPTION_JUMP'    => 'N',
        'AJAX_OPTION_HISTORY' => 'N',

        'SHOW_ROW_CHECKBOXES'       => true,
        'SHOW_CHECK_ALL_CHECKBOXES' => true,
        'SHOW_ROW_ACTIONS_MENU'     => true,
        'SHOW_GRID_SETTINGS_MENU'   => true,
        'SHOW_NAVIGATION_PANEL'     => true,
        'SHOW_PAGINATION'           => true,

        'ENABLE_NEXT_PAGE'                 => true,
        'SHOW_SELECTED_COUNTER'            => true,
        'SHOW_TOTAL_COUNTER'               => true,
        'SHOW_PAGESIZE'                    => true,
        'ALLOW_COLUMNS_SORT'               => true,
        'ALLOW_COLUMNS_RESIZE'             => true,
        'ALLOW_HORIZONTAL_SCROLL'          => true,
        'ALLOW_SORT'                       => true,
        'ALLOW_PIN_HEADER'                 => true,
        'TOTAL_ROWS_COUNT'                 => $table->getCount(),
        'SHOW_ACTION_PANEL'                => true,
        'ACTION_PANEL'                     => [
            'GROUPS' => [
                'TYPE' => [
                    'ITEMS' => [
                        $snippets->getRemoveButton(),
                    ],
                ],
            ],
        ],
        'SHOW_SELECT_ALL_RECORDS_CHECKBOX' => true,
        'SHOW_GROUP_DELETE_BUTTON'         => true,
        'SHOW_GROUP_EDIT_BUTTON'           => true,
    ]
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
