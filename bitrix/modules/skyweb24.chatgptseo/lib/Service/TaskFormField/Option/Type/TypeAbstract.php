<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type;

use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateAbstract;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationExecuteAbstract;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\OptionAbstract;

class TypeAbstract extends OptionAbstract
{
    public function __construct(
        ?string $name,
        ?string $code,
        protected ?TemplateAbstract $template = null,
        protected ?StrategyOperationExecuteAbstract $operation = null
    )
    {
        parent::__construct($name, $code);
    }

    public function getTemplate(): ?TemplateAbstract
    {
        return $this->template;
    }

    public function getStrategy(): ?StrategyOperationExecuteAbstract
    {
        return $this->operation;
    }
}