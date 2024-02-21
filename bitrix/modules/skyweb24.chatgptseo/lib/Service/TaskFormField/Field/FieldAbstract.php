<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Field;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\OptionGroup\OptionGroup;

abstract class FieldAbstract
{
    /** @param OptionAbstract[] $optionList */
    public function __construct(
        protected ?string $name,
        protected ?string $code = null,
        protected ?array $optionList = []
    ) {
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return FieldAbstract
     */
    public function setName(?string $name): FieldAbstract
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return FieldAbstract
     */
    public function setCode(?string $code): FieldAbstract
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptionList(): ?array
    {
        return $this->optionList;
    }


    /**
     * @param array|null $optionList
     * @return FieldAbstract
     */
    public function setOptionList(?array $optionList): FieldAbstract
    {
        $this->optionList = $optionList;
        return $this;
    }


    public function getOptionByCode(string $code): ?OptionAbstract
    {
        foreach ($this->optionList as $option) {
            if ($option->getCode() == $code) {
                return $option;
            }

            if ($option instanceof OptionGroup) {
                $nestedOption = $option->getOptionByCode($code);
                if ($nestedOption !== null) {
                    return $nestedOption;
                }
            }
        }

        return null;
    }

    public function getValueForTemplate(mixed $value): string
    {
        return $value;
    }

    public function getValueForTemplateOperation($optionCode)
    {
        return "";
    }
}