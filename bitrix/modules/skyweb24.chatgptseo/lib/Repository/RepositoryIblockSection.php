<?php

namespace Skyweb24\ChatgptSeo\Repository;

use Skyweb24\ChatgptSeo\Dto\DtoIblockSection;

class RepositoryIblockSection
{
    public function getById(int $id): DtoIblockSection|false
    {
        $response = \CIBlockSection::GetByID($id);
        if ($result = $response->GetNext()) {
            return new DtoIblockSection(
                $result['ID'],
                $result['CODE'],
                $result['IBLOCK_ID'],
                $result['NAME'],
                $result['DESCRIPTION'],
            );
        }
        return false;
    }
}