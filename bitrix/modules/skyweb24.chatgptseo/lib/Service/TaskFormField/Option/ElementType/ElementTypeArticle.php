<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\ElementType;

class ElementTypeArticle extends ElementTypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "article")
    {
        parent::__construct($name, $code);
    }
}