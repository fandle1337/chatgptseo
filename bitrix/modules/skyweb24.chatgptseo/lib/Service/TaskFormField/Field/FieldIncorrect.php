<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

class FieldIncorrect extends FieldAbstract
{
    public function __construct(
        ?string $name = 'incorrect',
        ?string $code = 'incorrect',
        ?array $optionList = []
    ) {
        parent::__construct($name, $code, $optionList);
    }
}