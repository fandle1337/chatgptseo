<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language;

class LanguageEnglish extends LanguageAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = "english"
    )
    {
        parent::__construct($name, $code);
    }
}