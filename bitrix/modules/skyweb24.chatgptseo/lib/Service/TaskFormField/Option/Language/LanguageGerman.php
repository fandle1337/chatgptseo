<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language;

class LanguageGerman extends LanguageAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = "german"
    )
    {
        parent::__construct($name, $code);
    }
}