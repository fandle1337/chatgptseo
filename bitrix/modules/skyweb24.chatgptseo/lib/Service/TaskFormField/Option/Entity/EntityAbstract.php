<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

abstract class EntityAbstract extends OptionAbstract
{
    public function __construct(
        protected ?string $name = null,
        protected ?string $code = null,
        protected ?array $featureList = []
    )
    {
        parent::__construct($name, $code);
    }

    public function getFeatureList(): array
    {
        return $this->featureList;
    }

}