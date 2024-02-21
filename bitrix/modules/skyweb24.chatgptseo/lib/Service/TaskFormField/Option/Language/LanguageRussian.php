<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language;

class LanguageRussian extends LanguageAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = "russian"
    )
    {
        parent::__construct($name, $code);
    }
}