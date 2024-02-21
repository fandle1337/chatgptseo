<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Feature;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class FeatureAbstract extends OptionAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = null)
    {
        parent::__construct($name, $code);
    }
}