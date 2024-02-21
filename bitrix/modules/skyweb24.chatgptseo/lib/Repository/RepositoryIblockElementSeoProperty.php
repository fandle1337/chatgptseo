<?php

namespace Skyweb24\ChatgptSeo\Repository;

use Bitrix\Iblock\InheritedProperty\ElementValues;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementSeoProperty;

class RepositoryIblockElementSeoProperty
{
    public function getById(int $iblockId, int $id): ?DtoIblockElementSeoProperty
    {
        if($values = (new ElementValues($iblockId, $id))->getValues()) {
            return new DtoIblockElementSeoProperty(
                $values["ELEMENT_META_DESCRIPTION"],
                $values["ELEMENT_META_TITLE"],
                $values["ELEMENT_META_KEYWORDS"],
                $values["ELEMENT_PAGE_TITLE"],
            );
        }
        return null;
    }
}