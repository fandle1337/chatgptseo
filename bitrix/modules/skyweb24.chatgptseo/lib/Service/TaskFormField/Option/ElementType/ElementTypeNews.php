<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType;

class ElementTypeNews extends ElementTypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "news")
    {
        parent::__construct($name, $code);
    }
}