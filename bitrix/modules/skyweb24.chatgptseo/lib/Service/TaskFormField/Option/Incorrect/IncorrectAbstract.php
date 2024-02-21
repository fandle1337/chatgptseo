<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Incorrect;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class IncorrectAbstract extends OptionAbstract

{
    public function __construct(
        ?string $name = null,
        ?string $code = null,
    )
    {
        parent::__construct($name, $code);
    }
}