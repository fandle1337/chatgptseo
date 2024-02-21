<?

namespace Skyweb24\Chatgptseo\Controller\Event;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;

class GridManager
{
    static array $gridTypes = ['tbl_iblock_element', 'tbl_iblock_list', 'tbl_product_admin', 'tbl_product_list'];
    private $currentGrid;
    private string $code = 'addToChatGPT';

    function __construct($grid)
    {
        $this->currentGrid = $grid;
    }

    public function isRequiredGrid(): bool
    {
        $tableName = $this->currentGrid->table_id;
        foreach (self::$gridTypes as $nextType) {
            if (str_contains($tableName, $nextType)) {
                return true;
            }
        }
        return false;
    }

    public function isAction(): bool
    {
        $actions = [$this->code];
        if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $actions)) {
            return true;
        }
        return false;
    }

    public function createReport()
    {

    }

    public function extendGrid()
    {
        global $USER;
        if (!($USER->IsAdmin())) {
            return;
        }
        $f = $this->currentGrid->arActions;

        $draftTaskList = ServiceLocator::getInstance()->get(RepositoryTask::class)->getAllByStatus(3);

        $items = $this->buildItemList($this->modifyTaskIdList($draftTaskList));

        $f[$this->code] = [
            "name"   => Loc::getMessage('SKYWEB24_CHATGPTSEO_BUTTON_NAME'),
            "type"   => "multicontrol",
            "action" => [
                [
                    "ACTION" => "RESET_CONTROLS",
                ],
                [
                    "ACTION" => "CREATE",
                    "DATA"   => [
                        [
                            "TYPE"  => "DROPDOWN",
                            "ID"    => "task_id",
                            "NAME"  => "task_id",
                            "ITEMS" => $items
                        ],
                        [
                            "TYPE"     => "BUTTON",
                            "ID"       => "apply_button",
                            "CLASS"    => "apply",
                            "TEXT"     => Loc::getMessage('SKYWEB24_CHATGPTSEO_BUTTON_APPLY'),
                            "ONCHANGE" => [
                                [
                                    "ACTION" => "CALLBACK",
                                    "DATA"   => [
                                        [
                                            "JS" => "BX.adminUiList.SendSelected(BX.Main.gridManager.data[0].id)",
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->currentGrid->AddGroupActionTable($f);
    }

    public static function manage($grid)
    {
        $newGrid = new self($grid);
        if ($newGrid->isRequiredGrid()) {
            $newGrid->extendGrid();
            if ($newGrid->isAction()) {
                $newGrid->createReport();
            }
        }
    }

    protected function modifyTaskIdList(?array $draftTaskList): array
    {
        if (!$draftTaskList) {
            return [];
        }
        foreach ($draftTaskList as $task) {
            $draftTaskIdList[] = $task['id'];
        }

        usort($draftTaskIdList, function ($a, $b) {
            return $b - $a;
        });

        return $draftTaskIdList;
    }

    protected function buildItemList(array $taskIdList): array
    {
        $name = Loc::getMessage('SKYWEB24_CHATGPTSEO_TASK_NAME');

        foreach ($taskIdList as $taskId) {
            $result[] = [
                "NAME"  => $name . $taskId,
                "VALUE" => $taskId,
            ];
        }

        return $result ?? [];
    }
}
