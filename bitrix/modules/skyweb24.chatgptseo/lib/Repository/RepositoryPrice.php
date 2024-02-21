<?php

namespace Skyweb24\ChatgptSeo\Repository;

class RepositoryPrice
{
    public function getAll(): ?array
    {
        if (\Bitrix\Main\Loader::includeModule("catalog")) {
            $arPriceTypes = \CCatalogGroup::GetList([], [], [], [], ['*']);
            while ($arPriceType = $arPriceTypes->Fetch()) {
                $result[] = $arPriceType;
            }
            return $result ?? null;
        }

        return null;
    }

    public function getPriceById(int $id, int $priceId): array|false
    {
        if (\Bitrix\Main\Loader::includeModule("catalog")) {
            $arPrice = \Bitrix\Catalog\PriceTable::getList([
                'filter' => [
                    'PRODUCT_ID'       => $id,
                    'CATALOG_GROUP_ID' => $priceId,
                ],
            ]);

            if (!$result = $arPrice->fetch()) {
                return false;
            }

            return $result;
        }
        return false;
    }
}