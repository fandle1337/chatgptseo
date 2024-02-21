<?php

use Bitrix\Main\Application;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\IO\File;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\UI\Extension;
use Skyweb24\ChatgptSeo\Cache\ServiceAiModelCache;
use Skyweb24\ChatgptSeo\Cache\ServiceCheckProxyCache;
use Skyweb24\ChatgptSeo\Cache\ServiceClientCache;
use Skyweb24\ChatgptSeo\Enum\EnumPaymentType;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;
use Skyweb24\ChatgptSeo\Helper\HelperColorBalance;
use Skyweb24\ChatgptSeo\Repository\RepositorySetting;
use Skyweb24\ChatgptSeo\Service\Api\Module\Dto\DtoClientInfo;
use Skyweb24\ChatgptSeo\Service\Statistics\Fill\ServiceFillName;
use Skyweb24\ChatgptSeo\Service\Statistics\ServiceCountTotalSpent;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();

global $APPLICATION;
$module_id = 'skyweb24.chatgptseo';
Loader::includeModule($module_id);
Loader::includeModule("main");
Loader::includeModule("currency");
CJSCore::Init(['skyweb24.chatgptseo']);
CJSCore::Init(['currency']);
$currencyFormat = CCurrencyLang::GetFormatDescription('RUB');
Extension::load('amcharts4');
Extension::load('ui.hint');
Extension::load("ui.progressbar");
Extension::load("ui.buttons.icons");
Extension::load("ui.buttons");
Extension::load("ui.alerts");
Asset::getInstance()->addJs("https://cdn.amcharts.com/lib/4/themes/animated.js");
Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . '/modules/main/options.php');

if (!file_exists($_SERVER["DOCUMENT_ROOT"] . EnumSettingApp::LOG_PATH)) {
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . EnumSettingApp::LOG_PATH, '');
}

$logFile = new File($_SERVER["DOCUMENT_ROOT"] . EnumSettingApp::LOG_PATH);
$logFileSize = $logFile->getSize();


$aTabs = [
    [
        "DIV"     => "sw24_general_settings_main",
        "TAB"     => Loc::getMessage("skyweb24.chatgptseo_GENERAL_MAIN"),
        "TITLE"   => Loc::getMessage("skyweb24.chatgptseo_GENERAL_MAIN_TITLE"),
        "OPTIONS" => [
            [
                'active',
                Loc::getMessage("skyweb24.chatgptseo_ACTIVE"),
                'Y',
                ['checkbox'],
            ],
            [
                'hide_informer',
                Loc::getMessage("skyweb24.chatgptseo_INFORMER_ACTIVE"),
                'Y',
                ['checkbox'],
            ],
            [
                EnumSettingApp::PERSONAL_CHAT_GPT_KEY_ACTIVE,
                Loc::getMessage("skyweb24.chatgptseo_API_KEY"),
                'N',
                ['checkbox'],
            ],
        ],
    ],
    [
        "DIV"     => "sw24_general_logs",
        "TAB"     => Loc::getMessage("SKYWEB24_CHATGPTSEO_LOGS_TAB"),
        "TITLE"   => Loc::getMessage("SKYWEB24_CHATGPTSEO_LOGS_TITLE"),
        "OPTIONS" => [
            [
                'delete_log_file',
                Loc::getMessage('SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_LABEL'),
                '<a href="javascript:void(0)" id="clear-log-file" class="ui-btn ui-btn-xs ui-btn-danger-dark"> 
                    ' . Loc::getMessage('SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_CLEAN') . ' 
                </a>',
                ['statichtml'],
            ],
            [
                'note' => '<div style="text-align: left"><div class="log-file-size">' . Loc::getMessage("SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_SIZE") . '<span>' . CFile::FormatSize($logFileSize) . '</span>' . '</div>' .
                    '<div><a target="_blank" href="/bitrix/admin/fileman_file_view.php?lang=ru&site=s1&path=' .
                    EnumSettingApp::LOG_PATH . '">' . Loc::getMessage("SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_PATH") .
                    '</a></div></div>'
            ],
        ],
    ],
    [
        "DIV"   => "sw24_general_rights",
        "TAB"   => Loc::getMessage("MAIN_TAB_RIGHTS"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
    ],
];


if ($request->isPost() && $request['Update'] && check_bitrix_sessid()) {

    if (!empty($aTabs[0]['OPTIONS'])) {
        __AdmSettingsSaveOptions($module_id, $aTabs[0]['OPTIONS']);
    }

    if (!empty($aTabs[1]['OPTIONS'])) {
        __AdmSettingsSaveOptions($module_id, $aTabs[1]['OPTIONS']);
    }

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_CHAT_GPT_KEY,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_PROXY_ADDRESS,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_PROXY_PORT,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_PROXY_LOGIN,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_PROXY_PASSWORD,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::GPT_MODEL,
            null,
            null,
            ['text'],
        ]
    ]);

    __AdmSettingsSaveOptions($module_id, [
        [
            EnumSettingApp::PERSONAL_GPT_MODEL,
            null,
            null,
            ['text'],
        ]
    ]);
}

$personalChatGptKey = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_CHAT_GPT_KEY);

$choosenAiModel = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::GPT_MODEL);

$choosenPersonalAiModel = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_GPT_MODEL);

$personalProxyAddress = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_PROXY_ADDRESS);

$personalProxyPort = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_PROXY_PORT);

$personalProxyLogin = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_PROXY_LOGIN);

$personalProxyPassword = ServiceLocator::getInstance()->get(RepositorySetting::class)
    ->getValue(EnumSettingApp::PERSONAL_PROXY_PASSWORD);

$gptKeyIsValid = false;
$proxyIsValid = ServiceLocator::getInstance()
    ->get(ServiceCheckProxyCache::class)
    ->check(
        $personalProxyAddress,
        (int)$personalProxyPort,
        $personalProxyLogin,
        $personalProxyPassword,
    );

if ($proxyIsValid) {
    $gptKeyIsValid = $gptModelList = ServiceLocator::getInstance()
        ->get(ServiceAiModelCache::class)
        ->getList(
            $personalChatGptKey,
            [
                $personalProxyAddress,
                (int)$personalProxyPort,
                $personalProxyLogin,
                $personalProxyPassword,
            ]
        );
}

try {
    $dtoClientInfo = ServiceLocator::getInstance()->get(ServiceClientCache::class)->info();
} catch (ExceptionHttpClient $e) {
    $dtoClientInfo = new DtoClientInfo();
    $message = Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_SERVICE_NOT_AVAILABLE');
}

foreach ($dtoClientInfo->paymentHistory as $key => $payment) {
    $rows[] = [
        'id'   => $key,
        'data' => [
            'date_payed' => ConvertTimeStamp(strtotime($payment['date_payed'])),
            'price'      => $payment['price'],
            'type'       => EnumPaymentType::getLang($payment['type']),
        ]
    ];
}
$columns = [
    [
        'id'      => 'date_payed',
        'name'    => Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_PAYMENT_DATE"),
        'sort'    => 'date_payed',
        'default' => true
    ],
    [
        'id'      => 'price',
        'name'    => Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_PAYMENT_PRICE"),
        'sort'    => 'price',
        'default' => true
    ],
    [
        'id'      => 'type',
        'name'    => Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_PAYMENT_TYPE"),
        'sort'    => 'type',
        'default' => true
    ],
];

$filledTaskStats = ServiceLocator::getInstance()->get(ServiceFillName::class)
    ->fillNames($dtoClientInfo->usageStatistics['usages_by_task']);

$tabControl = new CAdminTabControl("tabControl_sw24", $aTabs);
$tabControl->Begin();
?>
    <form class="bidding_settings" method="post"
          action="<?php echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($module_id) ?>&amp;lang=<?= LANGUAGE_ID ?>">
        <?php $tabControl->BeginNextTab(); ?>
        <?php __AdmSettingsDrawList($module_id, $aTabs[0]['OPTIONS']); ?>
        <tr>
            <td width="100%" colspan="2">
                <div data-tab-content="1">
                    <table class="adm-detail-content-table edit-table mb-3">
                        <tbody>
                        <? if ($gptModelList): ?>
                            <tr>
                                <td width="50%" class="adm-detail-content-cell-l">
                                    <label for="ai-model">
                                        <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_AI_MODEL") ?>
                                    </label>
                                </td>
                                <td width="50%" class="adm-detail-content-cell-r">
                                    <div class="flex">
                                        <select
                                            style="width: 462px"
                                            id="<?= EnumSettingApp::PERSONAL_GPT_MODEL ?>"
                                            name="<?= EnumSettingApp::PERSONAL_GPT_MODEL ?>"
                                        >
                                            <?
                                            foreach ($gptModelList as $model) { ?>
                                                <option
                                                    value="<?= $model['id'] ?>" <?= $model['id'] === $choosenPersonalAiModel ? 'selected' : '' ?>>
                                                    <?= $model['id'] ?>
                                                </option>
                                                <?
                                            } ?>
                                        </select>
                                        <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= !$gptKeyIsValid ? 'red' : 'green' ?>"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <? endif; ?>
                        <tr>
                            <td width="50%" class="adm-detail-content-cell-l">
                                <label for="gpt_token_key">
                                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_GPT_TOKEN_KEY_LABEL") ?>
                                </label>
                            </td>
                            <td width="50%" class="adm-detail-content-cell-r">
                                <div class="flex">
                                    <input
                                        style="width: 450px"
                                        type="text"
                                        id="<?= EnumSettingApp::PERSONAL_CHAT_GPT_KEY ?>"
                                        name="<?= EnumSettingApp::PERSONAL_CHAT_GPT_KEY ?>"
                                        value="<?= $personalChatGptKey ?>"
                                    >
                                    <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= !$gptKeyIsValid ? 'red' : 'green' ?>"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="adm-detail-content-cell-l">
                                <label for="proxy_address">
                                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_PROXY_ADDRESS_LABEL") ?>
                                </label>
                            </td>
                            <td width="50%" class="adm-detail-content-cell-r">
                                <div class="flex">
                                    <input
                                        style="width: 450px"
                                        type="text"
                                        id="<?= EnumSettingApp::PERSONAL_PROXY_ADDRESS ?>"
                                        name="<?= EnumSettingApp::PERSONAL_PROXY_ADDRESS ?>"
                                        value="<?= $personalProxyAddress ?>"
                                    >
                                    <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= $proxyIsValid ? 'green' : 'red' ?>"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="adm-detail-content-cell-l">
                                <label for="proxy_address">
                                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_PROXY_PORT_LABEL") ?>
                                </label>
                            </td>
                            <td width="50%" class="adm-detail-content-cell-r">
                                <div class="flex">
                                    <input
                                        style="width: 450px"
                                        type="text"
                                        id="<?= EnumSettingApp::PERSONAL_PROXY_PORT ?>"
                                        name="<?= EnumSettingApp::PERSONAL_PROXY_PORT ?>"
                                        value="<?= $personalProxyPort ?>"
                                    >
                                    <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= $proxyIsValid ? 'green' : 'red' ?>"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="adm-detail-content-cell-l">
                                <label for="proxy_login">
                                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_PROXY_LOGIN_LABEL") ?>
                                </label>
                            </td>
                            <td width="50%" class="adm-detail-content-cell-r">
                                <div class="flex">
                                    <input
                                        style="width: 450px"
                                        type="text"
                                        id="<?= EnumSettingApp::PERSONAL_PROXY_LOGIN ?>"
                                        name="<?= EnumSettingApp::PERSONAL_PROXY_LOGIN ?>"
                                        value="<?= $personalProxyLogin ?>"
                                    >
                                    <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= $proxyIsValid ? 'green' : 'red' ?>"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" class="adm-detail-content-cell-l">
                                <label for="proxy_password">
                                    <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_PROXY_PASSWORD_LABEL") ?>
                                </label>
                            </td>
                            <td class="adm-detail-content-cell-r">
                                <div class="flex">
                                    <input
                                        style="width: 450px"
                                        type="password"
                                        id="<?= EnumSettingApp::PERSONAL_PROXY_PASSWORD ?>"
                                        name="<?= EnumSettingApp::PERSONAL_PROXY_PASSWORD ?>"
                                        value="<?= $personalProxyPassword ?>"
                                    >
                                    <div class="icon">
                                        <span
                                            class="adm-lamp adm-lamp-in-list adm-lamp-<?= $proxyIsValid ? 'green' : 'red' ?>"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <? if (!$proxyIsValid || !$gptKeyIsValid): ?>
                        <div class="ui-alert ui-alert-inline ui-alert-danger error-message">
                        <span class="ui-alert-message text-message">
                            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_ERROR_VALIDATE") ?>
                        </span>
                        </div>
                    <? endif; ?>
                    <div class="ui-alert ui-alert-inline ui-alert-warning proxy-info">
                        <span class="ui-alert-message">
                            <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_PROXY_INFO") ?>
                        </span>
                    </div>
                </div>
                <div data-tab-content="2">
                    <table class="adm-detail-content-table edit-table">
                        <? if (!empty($dtoClientInfo->modelOptions)): ?>
                            <tbody>
                            <tr>
                                <td width="50%" class="adm-detail-content-cell-l">
                                    <label for="ai-model">
                                        <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_AI_MODEL") ?>
                                    </label>
                                </td>
                                <td width="50%" class="adm-detail-content-cell-r">
                                    <select
                                        style="width: 53%"
                                        id="<?= EnumSettingApp::GPT_MODEL ?>"
                                        name="<?= EnumSettingApp::GPT_MODEL ?>"
                                    >
                                        <?php foreach ($dtoClientInfo->modelOptions as $modelOption): ?>
                                            <option
                                                value="<?= $modelOption['code'] ?>"
                                                <?= $choosenAiModel === $modelOption['code'] ? 'selected' : '' ?>
                                            >
                                                <?= $modelOption['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        <? endif; ?>
                    </table>
                    <? if ($dtoClientInfo->balance): ?>
                        <div class="client-statistics">
                            <div class="balance">
                                <div class="ui-alert ui-alert-inline <?= HelperColorBalance::getColor($dtoClientInfo->balance)?>">
                                <span class="ui-alert-message">
                                    <div class="balance-name">
                                        <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_BALANCE') ?>
                                    </div>
                                    <div class="balance-count">
                                        <?= \CurrencyFormat($dtoClientInfo->balance, 'RUB') ?>
                                    </div>
                                </span>
                                </div>
                            </div>
                            <div class="market">
                                <a href="https://skyweb24.ru/catalog/add-options/skyweb24.chatgptseo-tokens/" target="_blank">
                                    <button class="ui-btn ui-btn-success ui-btn-icon-add" onclick="handleButtonClick(event)">
                                        <?= Loc::getMessage("SKYWEB24_CHATGPTSEO_SETTING_INCREASE_BALANCE")?>
                                    </button>
                                </a>

                                <script>
                                    function handleButtonClick(event) {
                                        event.preventDefault();
                                        window.open("https://skyweb24.ru/catalog/add-options/skyweb24.chatgptseo-tokens/", "_blank");
                                    }
                                </script>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (!empty($message)): ?>
                        <div class="message">
                            <div class="ui-alert ui-alert-inline ui-alert-danger">
                                <span class="ui-alert-message">
                                    <?= $message ?>
                                </span>
                            </div>
                        </div>
                    <? endif; ?>
                    <?php if (!empty($dtoClientInfo->usageStatistics['usages_by_task'])): ?>
                    <div class="usage-statistics">
                        <div class="chart-labels mb-3">
                            <?php if (!empty($dtoClientInfo->usageStatistics['usages_by_task'])): ?>
                                <div class="label">
                                    <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_USER_USAGES') ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($dtoClientInfo->usageStatistics['usages_by_model'])): ?>
                                <div class="label">
                                    <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_MODEL_USAGES') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="charts mb-3">
                            <?php if (!empty($dtoClientInfo->usageStatistics['usages_by_task'])): ?>
                                <div class="user-usage-chart">
                                    <div id="userUsageChart" style="width: 100%; height: 400px;"></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($dtoClientInfo->usageStatistics['usages_by_model'])): ?>
                                <div class="model-usage-chart">
                                    <div id="modelUsageChart" style="width: 100%; height: 400px;"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="graph-label mb-3">
                            <div class="label">
                                <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY') ?>
                            </div>
                        </div>
                        <div class="chronology-graph mb-3">
                            <div id="chronologyGraph" style="width: 100%; height: 300px"></div>
                        </div>
                        <div class="payment-history mb-2">
                            <div class="label mb-2">
                                <?= Loc::getMessage('SKYWEB24_CHATGPTSEO_SETTING_PAYMENT_HISTORY') ?>
                            </div>
                            <div class="table">
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:main.ui.grid',
                                    '',
                                    [
                                        'GRID_ID'                          => 'payment_history',
                                        'COLUMNS'                          => $columns,
                                        'ROWS'                             => $rows ?? [],
                                        'SHOW_ROW_CHECKBOXES'              => false,
                                        'SHOW_CHECK_ALL_CHECKBOXES'        => false,
                                        'SHOW_ROW_ACTIONS_MENU'            => false,
                                        'SHOW_GRID_SETTINGS_MENU'          => false,
                                        'SHOW_NAVIGATION_PANEL'            => false,
                                        'SHOW_PAGINATION'                  => false,
                                        'ENABLE_NEXT_PAGE'                 => false,
                                        'SHOW_SELECTED_COUNTER'            => false,
                                        'SHOW_TOTAL_COUNTER'               => false,
                                        'SHOW_PAGESIZE'                    => false,
                                        'ALLOW_COLUMNS_SORT'               => false,
                                        'ALLOW_COLUMNS_RESIZE'             => false,
                                        'ALLOW_HORIZONTAL_SCROLL'          => false,
                                        'ALLOW_SORT'                       => false,
                                        'ALLOW_PIN_HEADER'                 => false,
                                        'SHOW_ACTION_PANEL'                => false,
                                        'SHOW_SELECT_ALL_RECORDS_CHECKBOX' => false,
                                        'SHOW_GROUP_DELETE_BUTTON'         => false,
                                        'SHOW_GROUP_EDIT_BUTTON'           => false,
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </td>
        </tr>


        <script>
            BX.ready(() => {
                new BuilderChartDiagram().createChart(
                    'userUsageChart',
                    <?= \Bitrix\Main\Web\Json::encode($filledTaskStats); ?>,
                    <?= CUtil::PhpToJSObject($currencyFormat, false, true); ?>
                );

                new BuilderChartDiagram().createChart(
                    'modelUsageChart',
                    <?= \Bitrix\Main\Web\Json::encode($dtoClientInfo->usageStatistics['usages_by_model'])?>,
                    <?= CUtil::PhpToJSObject($currencyFormat, false, true); ?>
                );

                new BuilderChartGraph().createGraph(
                    'chronologyGraph',
                    <?= \Bitrix\Main\Web\Json::encode($filledTaskStats)?>,
                    <?= CUtil::PhpToJSObject($currencyFormat, false, true); ?>
                )


                function hideTabAll() {
                    document.querySelectorAll(`[data-tab-content]`).forEach(node => {
                        node.style.display = 'none'
                    })
                }

                function showTab(code) {
                    hideTabAll();
                    document.querySelector(`[data-tab-content='${code}']`).style.display = "block"
                }

                function isUsePersonalToken() {
                    return document.querySelector(`#PERSONAL_CHAT_GPT_KEY_ACTIVE`).checked;
                }

                isUsePersonalToken() ? showTab(1) : showTab(2)

                document.querySelector(`#PERSONAL_CHAT_GPT_KEY_ACTIVE`).addEventListener("click", (e) => {
                    isUsePersonalToken() ? showTab(1) : showTab(2)
                })

                const button = document.querySelector(`#clear-log-file`)
                if (button) {
                    button.addEventListener('click', function (e) {
                        if (e.target.id === 'clear-log-file') {
                            if (!confirm(BX.message('SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_CLEAR'))) {
                                return false;
                            }

                            return new Promise((resolve, reject) => {
                                BX.ajax.runAction("skyweb24:chatgptseo.api.ControllerOptions.clearLogFile", {
                                    data: {}
                                }).then((response) => {
                                    const spanElement = document.querySelector('.log-file-size span')
                                    if (spanElement) {
                                        spanElement.textContent = BX.message('SKYWEB24_CHATGPTSEO_LOGS_LOG_FILE_CLEAN')
                                    }
                                    alert(response.data)
                                }).catch(res => reject(res))
                            });
                        }
                    })
                }
            })
        </script>

        <?php $tabControl->BeginNextTab(); ?>
        <?php __AdmSettingsDrawList($module_id, $aTabs[1]['OPTIONS']); ?>

        <?php $tabControl->BeginNextTab(); ?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php"); ?>

        <?php $tabControl->Buttons(); ?>
        <input type="submit" name="Update" class="adm-btn-save" value="<?= Loc::getMessage("MAIN_SAVE") ?>">
        <input type="reset" name="reset" value="<?= Loc::getMessage("MAIN_RESET") ?>">
        <?= bitrix_sessid_post(); ?>
    </form>
<?php $tabControl->End(); ?>