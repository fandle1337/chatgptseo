<?php

namespace Skyweb24\ChatgptSeo\Service\Api\Module\Dto;

class DtoClientInfo
{
    public function __construct(
        public ?float $balance = null,
        public ?array $usageStatistics = [],
        public ?array $paymentHistory = [],
        public ?array $modelOptions = [],
    )
    {
    }

}