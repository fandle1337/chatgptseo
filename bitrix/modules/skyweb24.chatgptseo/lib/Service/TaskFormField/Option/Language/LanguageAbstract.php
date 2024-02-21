<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Language;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class LanguageAbstract extends OptionAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null
    )
    {
        parent::__construct(
            $name,
            $code
        );
    }
}