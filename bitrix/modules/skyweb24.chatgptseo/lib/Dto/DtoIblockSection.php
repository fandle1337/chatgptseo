<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoIblockSection extends DtoAbstract
{
    public function __construct(
        public ?int    $id = null,
        public ?string $code = null,
        public ?int    $iblockId = null,
        public ?string $title = null,
        public ?string $description = null,
    )
    {
        parent::__construct();
    }
}