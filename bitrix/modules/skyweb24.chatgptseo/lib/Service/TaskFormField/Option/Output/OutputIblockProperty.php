<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputIblockProperty extends OutputAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null
    )
    {
        parent::__construct($name, $code);
    }
}