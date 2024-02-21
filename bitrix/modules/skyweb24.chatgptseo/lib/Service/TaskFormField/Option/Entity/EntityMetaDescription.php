<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

class EntityMetaDescription extends EntityAbstract
{
     public function __construct(
         ?string $name,
         ?string $code = "ELEMENT_META_DESCRIPTION",
         ?array $featureList = [])
     {
        parent::__construct($name, $code, $featureList);
     }
}