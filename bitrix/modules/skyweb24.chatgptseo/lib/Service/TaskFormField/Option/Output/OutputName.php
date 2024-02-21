<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputName extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "NAME"
    )
    {
        parent::__construct($name, $code);
    }
}