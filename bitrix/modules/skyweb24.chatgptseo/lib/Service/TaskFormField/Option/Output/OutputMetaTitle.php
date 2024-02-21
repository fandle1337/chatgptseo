<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputMetaTitle extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_META_TITLE"
    )
    {
        parent::__construct($name, $code);
    }
}