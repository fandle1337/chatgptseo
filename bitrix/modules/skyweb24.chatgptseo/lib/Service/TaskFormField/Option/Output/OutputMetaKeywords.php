<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputMetaKeywords extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_META_KEYWORDS"
    )
    {
        parent::__construct($name, $code);
    }
}