<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature;

class FeatureHtml extends FeatureAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "html")
    {
        parent::__construct($name, $code);
    }
}