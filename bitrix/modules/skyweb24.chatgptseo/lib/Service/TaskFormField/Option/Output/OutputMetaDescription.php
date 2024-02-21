<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputMetaDescription extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_META_DESCRIPTION"
    )
    {
        parent::__construct($name, $code);
    }
}