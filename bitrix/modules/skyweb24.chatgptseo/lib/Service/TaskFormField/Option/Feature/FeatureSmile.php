<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature;

class FeatureSmile extends FeatureAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = 'smile')
    {
        parent::__construct($name, $code);
    }
}