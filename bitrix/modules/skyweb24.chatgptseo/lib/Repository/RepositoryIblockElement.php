<?php

namespace Skyweb24\ChatgptSeo\Repository;

use CIBlockElement;
use CModule;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElement;

CModule::IncludeModule("iblock");

class  RepositoryIblockElement
{
    public function getById(int $id): DtoIblockElement|false
    {
        $res = CIBlockElement::GetList(
            [],
            [
                "ID" => $id
            ],
            false,
            false,
            [
                "*",
                "PROPERTY_*",
            ]
        );

        if (!$ob = $res->GetNextElement()) {
            return false;
        }

        $fields = $ob->GetFields();
        $properties = $ob->GetProperties() ?? [];

        return new DtoIblockElement(
            $fields["ID"],
            $fields["IBLOCK_ID"],
            $fields["IBLOCK_TYPE_ID"],
            $fields["NAME"],
            $fields["PREVIEW_TEXT"],
            $fields["DETAIL_TEXT"],
            $properties,
            $fields['IBLOCK_SECTION_ID'],
        );
    }

    public function update($id, array $data)
    {
        return (new CIBlockElement())->update($id, $data);
    }
}