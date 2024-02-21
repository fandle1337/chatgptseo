<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputDetailText extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "DETAIL_TEXT"
    )
    {
        parent::__construct($name, $code);
    }
}