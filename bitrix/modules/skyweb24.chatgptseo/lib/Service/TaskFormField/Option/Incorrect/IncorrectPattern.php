<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Incorrect;

class IncorrectPattern extends IncorrectAbstract
{
    public function __construct(
        ?string $name = 'incorrect',
        ?string $code = 'incorrect',
    )
    {
        parent::__construct($name, $code);
    }
}