<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output;

class OutputPreviewText extends OutputAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "PREVIEW_TEXT"
    )
    {
        parent::__construct($name, $code);
    }
}