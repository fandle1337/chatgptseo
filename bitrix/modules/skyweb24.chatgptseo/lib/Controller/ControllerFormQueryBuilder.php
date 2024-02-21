<?php

namespace Skyweb24\Chatgptseo\Controller;

use CModule;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\ActionFilter\Authentication;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElement;
use Skyweb24\ChatgptSeo\Dto\DtoTask;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Repository\RepositoryPrice;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Resource\ResourceQueryBuilderRule;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementCreate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementDelete;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldElementType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldEntity;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldIncorrect;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldInput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldLanguage;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Incorrect\FactoryIncorrectOption;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\FactoryOptionInput;
use Skyweb24\ChatgptSeo\Validator\ValidatorTaskElement;

CModule::IncludeModule("iblock");

class ControllerFormQueryBuilder extends ControllerAbstract
{
    public function getOptionListAction(): array
    {
        $fieldPropertyList = ServiceLocator::getInstance()
            ->get(RepositoryIblockProperty::class)
            ->getById($this->request->get("iblock_id"), ["S"]);

        $outputOptionList = $inputOptionList = FactoryOptionInput::make($fieldPropertyList);

        $incorrectPropertyList = ServiceLocator::getInstance()
            ->get(RepositoryIblockProperty::class)
            ->getById($this->request->get("iblock_id"), ["S", "N"]);

        $priceList = ServiceLocator::getInstance()->get(RepositoryPrice::class)->getAll();

        $incorrectOptionList = FactoryIncorrectOption::make($incorrectPropertyList, $priceList);

        $entityList = [
            ServiceLocator::getInstance()->get(FieldType::class),
            ServiceLocator::getInstance()->get(FieldEntity::class),
            ServiceLocator::getInstance()->get(FieldOutput::class)->setOptionList($outputOptionList),
            ServiceLocator::getInstance()->get(FieldInput::class)->setOptionList($inputOptionList),
            ServiceLocator::getInstance()->get(FieldElementType::class),
            ServiceLocator::getInstance()->get(FieldIncorrect::class)->setOptionList($incorrectOptionList),
            ServiceLocator::getInstance()->get(FieldLanguage::class),
        ];

        return $this->response(new ResourceQueryBuilderRule($entityList));
    }

    public function storeAction(): array
    {
        $dtoTaskAdvanced = ServiceLocator::getInstance()
            ->get(AggregatorTaskAdvanced::class)
            ->getById($this->request->get("task_id"));

        return $this->response([
            "iblockId"       => $dtoTaskAdvanced->iblock_id,
            "operations"     => $dtoTaskAdvanced->operations ?? [],
            "operation_type" => $dtoTaskAdvanced->operation_type,
            "incorrect_text" => $dtoTaskAdvanced->incorrect_text,
            "element_type"   => $dtoTaskAdvanced->element_type,
            "status_disable" => !($dtoTaskAdvanced->status_id == EnumStatus::DRAFT),
        ]);
    }

    public function buildQueryAction(): string
    {
        $dtoTaskAdvanced = ServiceLocator::getInstance()
            ->get(AggregatorTaskAdvanced::class)
            ->getById($this->request->get("task_id"));

        $fieldOptionType = ServiceLocator::getInstance()
            ->get(FieldType::class)
            ->getOptionByCode($this->request->get("operation_type"));

        $templateOperation = $fieldOptionType->getTemplate();

        $aggregatorIblockElement = ServiceLocator::getInstance()
            ->get(AggregatorIblockElementAdvanced::class);

        foreach ($dtoTaskAdvanced->elements as $dtoTaskElement) {
            if ($dtoIblockElementAdvanced = $aggregatorIblockElement->getById($dtoTaskElement->element_id)) {
                $rows[] = $templateOperation
                    ->buildTemplate(
                        $this->request->get("operations"),
                        $this->request->get("element_type"),
                        $this->request->get("incorrect_text"),
                        $dtoIblockElementAdvanced
                    );
            }
        }
        return implode("\n", $rows ?? []);
    }

    public function operationExecuteAction()
    {
        // перевод таска в статус "в процессе"
        ServiceLocator::getInstance()
            ->get(ServiceTaskUpdate::class)
            ->update(
                $this->request->get("task_id"),
                [
                    'status_id' => 2
                ]
            );
    }

    public function addTaskElementAction()
    {
        $taskId = $this->request->get("taskId");
        $elementId = $this->request->get("elementId");

        /** @var DtoTask $dtoTask */
        $dtoTask = ServiceLocator::getInstance()->get(RepositoryTask::class)->getById($taskId);
        /** @var DtoIblockElement $dtoElement */
        $dtoElement = ServiceLocator::getInstance()->get(RepositoryIblockElement::class)->getById($elementId);

        if (empty((new ValidatorTaskElement())->addTask($taskId, $elementId))) {
            if ($dtoTask->iblock_id == $dtoElement->iblockId) {
                ServiceLocator::getInstance()
                    ->get(ServiceTaskElementCreate::class)
                    ->create(
                        [
                            'task_id'    => $taskId,
                            'element_id' => $elementId,
                            'status_id'  => '3',
                        ]
                    );
            }
        }
    }

    public function deleteElementsAction()
    {
        $taskId = $this->request->get("taskId");
        $iblockId = $this->request->get("iblockId");

        $dtoTaskAdvanced = ServiceLocator::getInstance()->get(AggregatorTaskAdvanced::class)->getById($taskId);

        if ($dtoTaskAdvanced->iblock_id != $iblockId) {
            ServiceLocator::getInstance()->get(ServiceTaskUpdate::class)->update($taskId,
                [
                    'iblock_id'      => $iblockId,
                    'incorrect_text' => ''
                ]
            );
            ServiceLocator::getInstance()->get(ServiceTaskElementDelete::class)->deleteAllByTaskId($taskId);
        }
    }

    public function configureActions(): array
    {
        return [
            'getOptionList' => [
                '-prefilters' => [
                    Authentication::class,
                ],
            ],
            'buildQuery'    => [
                '-prefilters' => [
                    Authentication::class,
                ],
            ],
            'store'         => [
                '-prefilters' => [
                    Authentication::class,
                ],
            ]
        ];
    }

    public function saveAction()
    {
        if (ServiceLocator::getInstance()
                ->get(RepositoryTask::class)
                ->getById($this->request
                    ->get("task_id"))
                ->status_id == EnumStatus::DRAFT
        ) {
            ServiceLocator::getInstance()
                ->get(ServiceTaskUpdate::class)
                ->update(
                    $this->request->get("task_id"),
                    [
                        'iblock_id'      => $this->request->get("iblock_id"),
                        'operation_type' => $this->request->get("operation_type"),
                        'element_type'   => $this->request->get("element_type"),
                        'incorrect_text' => $this->request->get("incorrect_text"),
                        'operations'     => json_encode($this->request->get("operations") ?? [], JSON_FORCE_OBJECT),
                    ]);
        }
    }
}