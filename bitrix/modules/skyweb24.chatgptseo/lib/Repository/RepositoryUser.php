<?php

namespace Skyweb24\ChatgptSeo\Repository;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UserTable;
use CUser;

class RepositoryUser
{
    public function getUserNameById(int $userId): string
    {
        $arUser = CUser::GetById($userId)->fetch();

        return trim(sprintf("[%s] %s", $arUser['ID'], $this->getFullName($arUser)));
    }

    public function getUserNamesByIdList(array $idList): array
    {
        $arUser = UserTable::getList([
            'filter' => [
                'ID' => $idList
            ]
        ]);

        while ($user = $arUser->fetch()) {
            $result[$user['ID']] = trim(sprintf("[%s] %s", $user['ID'], $this->getFullName($user)));
        }

        return $result ?? [];
    }

    protected function getFullName(array $user): string
    {
        return sprintf('%s %s', $user['LAST_NAME'] ?? '', $user['NAME'] ?? '');
    }
}