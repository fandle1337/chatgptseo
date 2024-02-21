<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType;

class ElementTypeService extends ElementTypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "service")
    {
        parent::__construct($name, $code);
    }
}