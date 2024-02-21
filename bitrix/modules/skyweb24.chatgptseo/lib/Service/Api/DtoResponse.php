<?php

namespace Skyweb24\ChatgptSeo\Service\Api;

class DtoResponse
{
    public function __construct(
        public string  $status,
        public mixed   $data,
        public int     $code = 200,
        public ?string $message = null
    )
    {
    }
}
