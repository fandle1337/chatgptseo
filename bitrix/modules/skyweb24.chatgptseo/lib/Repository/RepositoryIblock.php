<?php

namespace Skyweb24\ChatgptSeo\Repository;

use CIBlock;
use Skyweb24\ChatgptSeo\Dto\DtoIblock;

class RepositoryIblock
{
    public function getAllIblocks(): array
    {
        $iblock = CIblock::GetList([], [
            'ACTIVE' => 'Y',
        ]);
        while ($result = $iblock->fetch()) {
            $iblockList[] = [
                'id'   => $result['ID'],
                'name' => $result['NAME'],
            ];
        }
        return $iblockList ?? [];
    }

    public function getIdDefaultIblock(): int
    {
        $iblock = CIblock::GetList([], [])->fetch();
        return $iblock['ID'];

    }

    public function getById(int $id): DtoIblock|false
    {
        $response = \CIBlock::GetByID($id);
        if ($result = $response->GetNext()) {
            return new DtoIblock(
                $result['ID'],
                $result['CODE'],
                $result['NAME'],
                $result['DESCRIPTION'],
            );
        }
        return false;
    }
}