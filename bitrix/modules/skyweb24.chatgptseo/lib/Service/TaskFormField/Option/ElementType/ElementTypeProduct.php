<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType;

class ElementTypeProduct extends ElementTypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "product")
    {
        parent::__construct($name, $code);
    }
}