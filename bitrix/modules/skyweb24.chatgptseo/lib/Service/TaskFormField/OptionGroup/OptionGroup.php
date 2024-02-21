<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\OptionGroup;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

class OptionGroup
{
    public function __construct(
        protected ?string $name,
        protected ?string $code = null,
        protected ?array  $optionList = [],
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

    public function getOptionList(): array
    {
        return $this->optionList;
    }

    public function getOptionByCode(mixed $code): ?OptionAbstract
    {
        foreach ($this->optionList as $option) {
            if ($option->getCode() == $code) {
                return $option;
            }
        }
        return null;
    }
}
