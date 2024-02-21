<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputH1 extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_PAGE_TITLE"
    )
    {
        parent::__construct($name, $code);
    }
}