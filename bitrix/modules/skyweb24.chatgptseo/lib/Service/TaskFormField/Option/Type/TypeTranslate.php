<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type;

use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateAbstract;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateTranslate;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationExecuteAbstract;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationTranslateExecute;

class TypeTranslate extends TypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "translate",
        protected ?TemplateAbstract $template = new TemplateTranslate(new RepositoryIblockProperty(), new ServiceParseIncorrectText()),
        protected ?StrategyOperationExecuteAbstract $operation = new StrategyOperationTranslateExecute(new RepositoryIblockProperty())
    )
    {
        parent::__construct($name, $code, $this->template, $this->operation);
    }
}