<?php

namespace Skyweb24\ChatgptSeo\Repository;

use CIBlock;
use Skyweb24\ChatgptSeo\Dto\DtoTask;
use Skyweb24\ChatgptSeo\Model\ModelTasksTable;

class RepositoryTask
{

    public function __construct(public ModelTasksTable $model)
    {
    }

    public function getAll(?array $filter, int $offset, int $limit, $sort)
    {
        foreach ($filter as $key => $value) {
            if (empty($value)) {
                $filter = [];
                break;
            }
        }

        return $this->model::getList([
            'select'      => ['*'],
            'filter'      => $filter ?? [],
            'count_total' => true,
            'order'       => $sort,
            'offset'      => $offset,
            'limit'       => $limit,
        ]);
    }

    public function getByIdList(array $idList): array
    {
        $response = $this->model::getList([
            'select' => ['*'],
            'filter' => ['id' => $idList]
        ])->fetchAll();

        if (!$response) {
            return [];
        }

        foreach ($response as $row) {
            $result[] = new DtoTask(
                $row['id'],
                $row['user_id'],
                $row['iblock_id'],
                $row['date_create'],
                $row['date_complete'],
                $row['status_id'],
                $row['operation_type'],
                $row['element_type'],
                $row['incorrect_text'],
                $row['operations'],
            );
        }

        return $result ?? [];
    }

    public function getById(int $id): ?DtoTask
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['id' => $id]
        ])->fetch();

        if (empty($result)) {
            return null;
        }

        return new DtoTask(
            $result['id'],
            $result['user_id'],
            $result['iblock_id'],
            $result['date_create'],
            $result['date_complete'],
            $result['status_id'],
            $result['operation_type'],
            $result['element_type'],
            $result['incorrect_text'],
            $result['operations'],

        );
    }

    public function getDateById(int $taskId): string
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['id' => $taskId],
        ])->fetch();
        return $result['date_create'];
    }

    public function getStatusById(int $taskId): int
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['id' => $taskId],
        ])->fetch();
        return $result['status_id'];
    }

    public function getAllByStatus(int $status): array
    {
        return $this->model::getList([
            'select' => ['id'],
            'filter' => ['status_id' => $status]
        ])->fetchall();
    }

    public function getCount(): int
    {
        return $this->model::getCount();
    }

    public function getIblockByTaskId(int $taskId): ?string
    {
        $result = $this->model::getList([
            'select' => ['*'],
            'filter' => ['id' => $taskId],
        ])->fetch();
        $iblock = CIblock::GetList([], []);
        while ($res = $iblock->fetch()) {
            if ($res['ID'] == $result['iblock_id']) {
                return $res['NAME'];
            }
        }
        return null;
    }

    public function add(array $data)
    {
        return $this->model::add($data);
    }

    public function delete($taskId)
    {
        return $this->model::delete($taskId);
    }

    public function update(int $taskId, array $data)
    {
        return $this->model::update($taskId, $data);
    }

    public function getIblockById(int $taskId)
    {
        return $this->model::getList([
            'select' => ['iblock_id'],
            'filter' => ['id' => $taskId],
        ])->fetch();
    }
}