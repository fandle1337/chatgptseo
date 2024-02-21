<?php

namespace Skyweb24\ChatgptSeo\Dto;

use Skyweb24\ChatgptSeo\Enum\EnumStatus;

class DtoTaskAdvanced extends DtoAbstract
{
    /** @param DtoTaskElement[] $elements */
    public function __construct(
        public ?int    $id = null,
        public ?int    $iblock_id = null,
        public ?string $date_create = null,
        public ?string $date_complete = null,
        public ?int    $status_id = null,
        public ?string $operation_type = null,
        public ?string $element_type = null,
        public ?string $incorrect_text = null,
        public ?array  $operations = null,
        public ?array  $elements = null,
    )
    {
        parent::__construct();
    }

    public function getStatusId(): int
    {
        $statusListId = [];

        foreach ($this->elements as $dtoTaskElement) {
            $statusListId[] = $dtoTaskElement->status_id;
        }

        if (empty($statusListId)) {
            return EnumStatus::DRAFT;
        }

        if (in_array(EnumStatus::DRAFT, $statusListId)) {
            return EnumStatus::DRAFT;
        }

        if (in_array(EnumStatus::PROGRESS, $statusListId)) {
            return EnumStatus::PROGRESS;
        }

        if (in_array(EnumStatus::ERROR, $statusListId)) {
            return EnumStatus::ERROR;
        }

        if (in_array(EnumStatus::READY_TO_WORK, $statusListId)) {
            return EnumStatus::READY_TO_WORK;
        }
        return EnumStatus::DONE;
    }
}