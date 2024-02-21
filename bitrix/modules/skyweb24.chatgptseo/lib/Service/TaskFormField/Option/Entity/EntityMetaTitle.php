<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

class EntityMetaTitle extends EntityAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_META_TITLE",
        ?array $featureList = [])
    {
        parent::__construct($name, $code, $featureList);
    }
}