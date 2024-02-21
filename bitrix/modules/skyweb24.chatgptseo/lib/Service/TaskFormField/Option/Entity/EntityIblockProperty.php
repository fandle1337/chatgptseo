<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Entity;

class EntityIblockProperty extends EntityAbstract
{
    public function __construct(
        ?string $name = null,
        ?string $code = null
    )
    {
        parent::__construct($name, $code);
    }
}