<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option;

abstract class OptionAbstract
{
    public function __construct(
        protected ?string $name,
        protected ?string $code = null,
    )
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }


}