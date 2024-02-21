<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoIblockElementSeoProperty extends DtoAbstract
{
    public function __construct
    (
        public ?string $description = null,
        public ?string $title = null,
        public ?string $keywords = null,
        public ?string $h1 = null,

    ) {
        parent::__construct();
    }
}