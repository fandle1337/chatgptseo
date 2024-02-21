<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class ElementTypeAbstract extends OptionAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null)
    {
        parent::__construct($name, $code);
    }
}