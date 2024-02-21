<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoTask extends DtoAbstract
{
    public function __construct(
        public ?int    $id = null,
        public ?int    $user_id = null,
        public ?int    $iblock_id = null,
        public ?string $date_create = null,
        public ?string $date_complete = null,
        public ?int    $status_id = null,
        public ?string $operation_type = null,
        public ?string $element_type = null,
        public ?string $incorrect_text = null,
        public ?string $operations = null,
    )
    {
        parent::__construct();
    }
}