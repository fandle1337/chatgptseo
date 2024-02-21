<?php

namespace Skyweb24\ChatgptSeo\Repository;

use CIBlockElement;
use CIBlockProperty;

class RepositoryIblockProperty
{
    public function getById(int $iblockId, array $propertyType): array
    {
        $properties = CIBlockProperty::GetList([], ["ACTIVE" => "Y", "IBLOCK_ID" => $iblockId]);
        while ($prop_fields = $properties->GetNext()) {
            if (in_array($prop_fields["PROPERTY_TYPE"], $propertyType)) {
                $result[] = [
                    "code" => $prop_fields["CODE"],
                    "name" => $prop_fields["NAME"]
                ];
            }
        }
        return $result ?? [];
    }

    public function update(int $elementId, array $updateData)
    {
        CIBlockElement::SetPropertyValuesEx(
            $elementId,
            false,
            $updateData,
        );
    }
}