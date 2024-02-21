<?php

namespace Skyweb24\ChatgptSeo\Dto;

class DtoIblockElementAdvanced extends DtoAbstract
{
    public function __construct(
        public ?DtoIblockElement            $dtoIblockElement = null,
        public ?DtoIblockElementSeoProperty $dtoIblockElementSeoProperty = null
    )
    {
        parent::__construct();
    }
}