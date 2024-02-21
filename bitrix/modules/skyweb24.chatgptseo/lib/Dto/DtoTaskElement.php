<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoTaskElement extends DtoAbstract
{
    public function __construct(
        public ?int $id = null,
        public ?int $task_id = null,
        public ?int $element_id = null,
        public ?int $status_id = null,
    ) {
        parent::__construct();
    }
}