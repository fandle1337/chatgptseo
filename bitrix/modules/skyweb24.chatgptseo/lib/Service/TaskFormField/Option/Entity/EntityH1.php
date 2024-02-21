<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

class EntityH1 extends EntityAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "ELEMENT_PAGE_TITLE",
        ?array $featureList = [])
    {
        parent::__construct($name, $code, $featureList);
    }
}