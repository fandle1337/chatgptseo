<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoIblockElement extends DtoAbstract
{
    public function __construct(
        public ?int    $id = null,
        public ?int    $iblockId = null,
        public ?string $iblockType = null,
        public ?string $name = null,
        public ?string $previewText = null,
        public ?string $detailText = null,
        public ?array  $propertyList = [],
        public ?int    $iblockSectionId = null,
    )
    {
        parent::__construct();
    }
}