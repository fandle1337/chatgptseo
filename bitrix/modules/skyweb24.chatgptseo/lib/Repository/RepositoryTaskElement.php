<?php

namespace Skyweb24\ChatgptSeo\Repository;

use Skyweb24\ChatgptSeo\Dto\DtoTaskElement;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Model\ModelTaskElementsTable;

class RepositoryTaskElement
{
    public function __construct(public ModelTaskElementsTable $model)
    {
    }

    /** @return DtoTaskElement[] */
    public function getAllByTaskId(int $taskId): array
    {
        $result = $this->model->getList([
            'select' => ['*'],
            'filter' => ['task_id' => $taskId],
            'order'  => ['status_id' => 'desc'],
        ])->fetchAll();

        foreach ($result ?? [] as $item) {
            $rows[] = new DtoTaskElement(
                $item['id'],
                $item['task_id'],
                $item['element_id'],
                $item['status_id'],
            );
        }
        return $rows ?? [];
    }

    public function getAllWithErrorByTaskId(int $taskId): array
    {
        $result = $this->model->getList([
            'select' => ['*'],
            'filter' => [
                'task_id'   => $taskId,
                "status_id" => EnumStatus::ERROR
            ],
        ])->fetchAll();

        foreach ($result ?? [] as $item) {
            $rows[] = new DtoTaskElement(
                $item['id'],
                $item['task_id'],
                $item['element_id'],
                $item['status_id'],
            );
        }
        return $rows ?? [];
    }

    public function getAll(): array
    {
        $result = $this->model->getList([
            'select' => ['*'],
        ])->fetchAll();
        return $result ?? [];
    }

    public function countTotalElements(int $taskId): int
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['task_id' => $taskId],
        ])->fetchAll();
        return count($result);
    }

    public function countDoneElements(int $taskId): int
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['task_id' => $taskId, 'status_id' => '1']
        ])->fetchAll();
        return count($result);
    }

    public function getById(int $id)
    {
        return $this->model::getById($id);
    }

    public function deleteElementById(int $taskElementId)
    {
        return $this->model::delete($taskElementId);
    }

    public function getListElementIdByTaskId(int $taskId)
    {
        return $this->model::getList([
            'select' => ['id'],
            'filter' => ['task_id' => $taskId],
        ])->fetchAll();
    }

    public function getElementList(array $data)
    {
        return $this->model::getList($data)->fetchAll();
    }

    public function delete(int $elementId)
    {
        return $this->model::delete($elementId);
    }

    public function add($data)
    {
        return $this->model::add($data);
    }

    public function update(int $elementId, array $data)
    {
        return $this->model::update($elementId, $data);
    }

    public function getAllReadyToWorkByTaskId(int $taskId): array
    {
        $result = $this->model->getList([
            'select' => ['*'],
            'filter' => [
                'task_id'   => $taskId,
                "status_id" => EnumStatus::READY_TO_WORK
            ],
        ])->fetchAll();

        foreach ($result ?? [] as $item) {
            $rows[] = new DtoTaskElement(
                $item['id'],
                $item['task_id'],
                $item['element_id'],
                $item['status_id'],
            );
        }
        return $rows ?? [];
    }

    public function getCountByTaskId(int $taskId): int
    {
        return $this->model::getCount([
            'task_id' => $taskId
        ]);
    }

    public function getId(int $taskId, int $iblockElementId): int
    {
        $response = $this->model::getList([
            'select' => ['id'],
            'filter' => [
                'task_id'    => $taskId,
                'element_id' => $iblockElementId,
            ]
        ])->fetchAll();

        return $response['id'];
    }
}