<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Grid\Options;
use Bitrix\Main\Grid\Panel\Snippet;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Dto\DtoTaskAdvanced;
use Skyweb24\ChatgptSeo\Dto\DtoTaskElement;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblock;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementDelete;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

\Bitrix\Main\UI\Extension::load("ui.forms");
\Bitrix\Main\UI\Extension::load("ui.buttons");
\Bitrix\Main\UI\Extension::load("ui.buttons.icons");
\Bitrix\Main\UI\Extension::load("ui.alerts");
\Bitrix\Main\UI\Extension::load('skyweb24.chatgptseo.form-operation');

$module_id = 'skyweb24.chatgptseo';
Loader::IncludeModule($module_id);
CJSCore::Init(["skyweb24.chatgptseo"]);


$table = ServiceLocator::getInstance()->get(RepositoryTask::class);
$elTable = ServiceLocator::getInstance()->get(RepositoryTaskElement::class);
$snippets = new Snippet();

if ($table->getById($_REQUEST['id']) == null) {
    $APPLICATION->SetTitle(Loc::getMessage("SKYWEB24_CHATGPTSEO_404")); ?>
    <div
        class="ui-alert ui-alert-inline ui-alert-danger"><?= Loc::getMessage("SKYWEB24_CHATGPTSEO_404_EXPLANATION") ?></div>
    <?php die();
}

$APPLICATION->SetTitle(
    Loc::getMessage("SKYWEB24_CHATGPTSEO_TASK_NUMBER") .
    $_REQUEST['id'] . ' ' .
    Loc::getMessage("SKYWEB24_CHATGPTSEO_FROM") . ' ' .
    $table->getDateById($_REQUEST['id'])
);


$result = $elTable->getAllByTaskId($_REQUEST['id']);
$iblockList = (new RepositoryIblock())->getAllIblocks();
$iblockFromTable = $table->getIblockById($_REQUEST['id']);

if ($_REQUEST['action_button_elements'] == 'delete') {
    foreach ($_REQUEST['ID'] as $elementId) {
        ServiceLocator::getInstance()->get(ServiceTaskElementDelete::class)->deleteById($elementId);
    }
    LocalRedirect('/bitrix/admin/skyweb24_chatgptseo_task_edit.php?id=' . $_GET['id']);
}
/** @var DtoTaskAdvanced $dtoTaskAdvanced */
$dtoTaskAdvanced = ServiceLocator::getInstance()
    ->get(AggregatorTaskAdvanced::class)
    ->getById($_REQUEST['id']);
?>

<?php if ($dtoTaskAdvanced->getStatusId() == EnumStatus::DRAFT): ?>

    <div class="ui-alert ui-alert-inline ui-alert-warning" style="margin-bottom: unset">
    <span class="ui-alert-message">
        <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_STATUS") ?>
            <strong>
                <?= EnumStatus::getLang($dtoTaskAdvanced->getStatusId()) ?>
            </strong>
        <button class="ml-3 ui-btn ui-btn-icon-start ui-btn-success"
                onclick="location.href = '/bitrix/admin/skyweb24_chatgptseo_task_action.php?id=<?= $_GET['id'] ?>&action=start'">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_IN_WORK") ?>
        </button>
    </span>
        <div class="ml-5">
            <a href="https://skyweb24.ru/documentation/chatgptseo/lesson464/" target="_blank">
                <button class="ui-btn ui-btn-primary ui-btn-light-border ui-btn-icon-page">
                    <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_TASK_ELEMENTS_INSTRUCTION') ?>
                </button>
            </a>
        </div>
    </div>


<?php elseif ($dtoTaskAdvanced->getStatusId() == EnumStatus::PROGRESS ||
    $dtoTaskAdvanced->getStatusId() == EnumStatus::READY_TO_WORK): ?>
    <div class="ui-alert ui-alert-inline ui-alert-primary">
        <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_STATUS") ?>
                <strong>
                    <?= EnumStatus::getLang($dtoTaskAdvanced->getStatusId()) ?>
                </strong>
        </span>
    </div>
    <div class="ui-alert ui-alert-inline ui-alert-warning">
        <div class="adm-toolbar-panel-align-right">
            <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_IBLOCK") ?>
                <strong>
                    <?= ServiceLocator::getInstance()->get(RepositoryTask::class)->getIblockByTaskId($_REQUEST['id']) ?>
                </strong>
        </span>
        </div>
    </div>
<?php elseif ($dtoTaskAdvanced->getStatusId() == EnumStatus::ERROR): ?>
    <div class="ui-alert ui-alert-inline ui-alert-danger">
        <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_STATUS") ?>
                <strong>
                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_DONE_WITH_ERRORS") ?>
                </strong>
        </span>
    </div>
    <div class="ui-alert ui-alert-inline ui-alert-warning">
        <div class="adm-toolbar-panel-align-right">
            <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_IBLOCK") ?>
                <strong>
                    <?= ServiceLocator::getInstance()->get(RepositoryTask::class)->getIblockByTaskId($_REQUEST['id']) ?>
                </strong>
        </span>
        </div>
    </div>
    <div class="ui-alert ui-alert-danger">
    <span class="ui-alert-message">
        <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_TASK_ELEMENTS_ERROR_ALERT", [
            "#ACTION_URL_RESTART#" => "/bitrix/admin/skyweb24_chatgptseo_task_action.php?id=" . $_REQUEST['id'] . "&action=task_restart"
        ]) ?>
    </span>
    </div>
<?php else: ?>
    <div class="ui-alert ui-alert-inline ui-alert-success">
        <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_STATUS") ?>
                <strong>
                    <?= EnumStatus::getLang($dtoTaskAdvanced->getStatusId()) ?>
                </strong>
        </span>
    </div>
    <div class="ui-alert ui-alert-inline ui-alert-warning">
        <div class="adm-toolbar-panel-align-right">
            <span class="ui-alert-message">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CURRENT_IBLOCK") ?>
                <strong>
                    <?= ServiceLocator::getInstance()->get(RepositoryTask::class)->getIblockByTaskId($_REQUEST['id']) ?>
                </strong>
        </span>
        </div>
    </div>
<?php endif; ?>
<div style="padding-bottom: 10px; padding-top: 10px">
    <h3>
        <span title="<?= Loc::getMessage("SKYWEB24_CHATGPTSEO_TITLE_STEP_1") ?>">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_STEP_1") ?>
        </span>
    </h3>
</div>
<?php if ($dtoTaskAdvanced->getStatusId() == EnumStatus::DRAFT): ?>
    <div class="ui-alert ui-alert-inline ui-alert-default">
        <div class="adm-toolbar-panel-align-right">
            <input type="hidden" class="choosen-iblock">
            <label for="iblock_id"><?= Loc::getMessage("SKYWEB24_CHATGPTSEO_CHOOSE_IBLOCK") ?></label>
            <select class="ml-2 mr-3" id="iblock_id">
                <?php foreach ($iblockList as $iblock): ?>
                    <option value="<?= $iblock['id'] ?>"
                        <? if ($iblock['id'] == $iblockFromTable['iblock_id']) {
                            echo 'selected';
                        } ?>>
                        <?= $iblock['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" id="current_element_id">
            <button class="ui-btn ui-btn-icon-done ui-btn-secondary" data-btn-iblock-id>
                <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_APPLY") ?>
            </button>
            <button class="ui-btn ui-btn-icon-add ui-btn-primary" data-btn-add-element>
                <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_ADD_ELEMENT") ?>
            </button>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const selectElement = document.querySelector('#iblock_id')

        if (!selectElement) {
            return
        }

        let selectedOptionValue = selectElement.options[selectElement.selectedIndex].value
        document.querySelector('.choosen-iblock').value = selectedOptionValue

        document.querySelector('[data-btn-iblock-id]').addEventListener('click', (e) => {
            if (confirm(BX.message('SKYWEB24_CHATGPTSEO_CONFIRM'))) {
                let iblockId = document.querySelector('#iblock_id').value
                document.querySelector('.choosen-iblock').value = iblockId
                selectedOptionValue = iblockId
                let event = new CustomEvent("iblockId:change", {detail: iblockId})
                document.dispatchEvent(event)
            }
        })

        document.addEventListener("iblockId:change", (e) => {
            BX.ajax.runAction('skyweb24:chatgptseo.api.ControllerFormQueryBuilder.deleteElements', {
                data: {taskId: <?= $_GET['id'] ?>, iblockId: e.detail},
            }).then(e => {
                BX.Main.gridManager.reload('elements')
            })
        })
        document.querySelector('[data-btn-add-element]').addEventListener('click', (e) => {
            if (selectedOptionValue !== document.querySelector('#iblock_id').value) {
                alert(BX.message('SKYWEB24_CHATGPTSEO_ALERT'))
            } else {
                makeElementsAddWindow('ru', '', document.querySelector('#iblock_id').value)
            }
        })

        document.querySelector("#current_element_id").addEventListener("change", (e) => {
            BX.ajax.runAction('skyweb24:chatgptseo.api.ControllerFormQueryBuilder.addTaskElement', {
                data: {
                    elementId: e.target.value,
                    taskId: <?= $_GET['id']?>
                }
            })
                .then(e => {
                    BX.Main.gridManager.reload('elements')
                })
        })

        function makeElementsAddWindow(lang, callback, iblock_id) {
            const popup = window.open('/bitrix/admin/iblock_element_search.php?lang=' + lang
                + '&func_name=' + callback
                + '&IBLOCK_ID=' + iblock_id
                + '&task_id=' + <?= $_GET['id']?>
                + '&n=current_element_id'
                + '&set_filter=y', '', 'width=760,height=500')

            BX.addCustomEvent(popup, 'onClose', () => {
                BX.Main.gridManager.reload('elements')
            })
            return popup
        }
    })

    function confirmElementDelete(elementId) {
        if (confirm(BX.message('SKYWEB24_CHATGPTSEO_ELEMENT_CONFIRM_DELETE'))) {
            BX.ajax.runAction('skyweb24:chatgptseo.api.ControllerTaskEdit.deleteElement', {
                data: {
                    element_id: elementId,
                }
            })
                .then(e => {
                    if (e.data) {
                        BX.Main.gridManager.reload('elements')
                    }
                })
        }
    }
</script>


<?php $gridId = 'elements';

$gridOptions = new Options($gridId);

$sort = $gridOptions->GetSorting([
    'sort' => ['ID' => 'DESC'],
    'vars' => ['by' => 'by', 'order' => 'order']
]);
$navOption = $gridOptions->GetNavParams();

$columns = [
    ['id' => 'element_id', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_ID_ELEMENT"), 'sort' => 'element_id', 'default' => true],
    ['id' => 'name', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_NAME"), 'sort' => 'name', 'default' => true],
    ['id' => 'type', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE"), 'sort' => 'type', 'default' => true],
    ['id' => 'status_id', 'name' => Loc::getMessage("SKYWEB24_CHATGPTSEO_STATUS"), 'sort' => 'status_id', 'default' => true],

];

$types = [
    '1' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE_1"),
    '2' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE_2"),
    '3' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE_3"),
    '4' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE_4"),
    '6' => Loc::getMessage("SKYWEB24_CHATGPTSEO_TYPE_6"),
];

/** @var DtoTaskElement[] $result */
foreach ($result as $item) {

    if (!$dto = (new RepositoryIblockElement())->getById($item->element_id)) {
        continue;
    }

    $r = CIBlockElement::GetList([], [
        "ID"        => $item->element_id,
        "IBLOCK_ID" => $dto->iblockId
    ],
        false,
        false,
        [
            "CATALOG_TYPE",
        ]);
    $r = $r->GetNext();

    foreach ($types as $key => $value) {
        if ($r["CATALOG_TYPE"] == $key) {
            $r["CATALOG_TYPE"] = $value;
        }
    }

    $rows[] = [
        'id'      => $item->id,
        'data'    => [
            'id'         => $item->id,
            'task_id'    => $item->task_id,
            'element_id' => sprintf('<a target="_blank" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=%s&type=%s&lang=ru&ID=%s">%s</a>',
                $dto->iblockId,
                $dto->iblockType,
                $item->element_id,
                $item->element_id
            ),
            'name'       => $dto->name,
            'type'       => $r['CATALOG_TYPE'],
            'status_id'  => EnumStatus::getLang($item->status_id),
        ],
        'actions' => [
            $dtoTaskAdvanced->getStatusId() !== 3
                // ServiceLocator::getInstance()->get(RepositoryTask::class)->getStatusById($_REQUEST['id']) !== 3
                ? []
                : [
                'text'    => Loc::getMessage("SKYWEB24_CHATGPTSEO_DELETE"),
                'onclick' => 'confirmElementDelete(' . $item->id . ',' . $item->task_id . ')',
//                'href' => '/bitrix/admin/skyweb24_chatgptseo_task_action.php?id=' . $item->task_id . '&action=delete_element',
            ]
        ],
    ];
}

$pageSizes = [
    ['NAME' => "5", 'VALUE' => '5'],
    ['NAME' => '10', 'VALUE' => '10'],
    ['NAME' => '20', 'VALUE' => '20'],
    ['NAME' => '50', 'VALUE' => '50'],
    ['NAME' => '100', 'VALUE' => '100']
];

$nav = (new PageNavigation($gridId))
    ->allowAllRecords(false)
    ->setPageSize($navOption['nPageSize'])
    ->setPageSizes($pageSizes);

$nav->initFromUri();
?>
<div style="overflow-y: auto; max-height: 500px">
    <?php $APPLICATION->IncludeComponent(
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
            'SHOW_NAVIGATION_PANEL'     => false,
            'SHOW_PAGINATION'           => false,

            'SHOW_SELECTED_COUNTER'            => true,
            'SHOW_TOTAL_COUNTER'               => true,
            'SHOW_PAGESIZE'                    => true,
            'ALLOW_COLUMNS_SORT'               => true,
            'ALLOW_COLUMNS_RESIZE'             => true,
            'ALLOW_HORIZONTAL_SCROLL'          => true,
            'ALLOW_SORT'                       => false,
            'ALLOW_PIN_HEADER'                 => true,
            'TOTAL_ROWS_COUNT'                 => $table->getCount(),
            'SHOW_ACTION_PANEL'                => true,
            'ACTION_PANEL'                     => [
                'GROUPS' => [
                    'TYPE' => [
                        'ITEMS' => [
                            ServiceLocator::getInstance()->get(RepositoryTask::class)->getStatusById($_REQUEST['id']) !== 3 ? null : $snippets->getRemoveButton(),
                        ],
                    ]
                ],
            ],
            'SHOW_SELECT_ALL_RECORDS_CHECKBOX' => true,
            'SHOW_GROUP_DELETE_BUTTON'         => true,
            'SHOW_GROUP_EDIT_BUTTON'           => true,
        ]
    );
    ?>
</div>


<div style="padding-top: 10px; padding-bottom: 10px">
    <h3>
        <span title="<?= Loc::getMessage("SKYWEB24_CHATGPTSEO_TITLE_STEP_2") ?>">
            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_STEP_2") ?>
        </span>
    </h3>
</div>

<div id="form-build-query"></div>
<script>
    BX.ready(e => {
        Skyweb24ChatGPTAdmin("#form-build-query")
    })
</script>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>


