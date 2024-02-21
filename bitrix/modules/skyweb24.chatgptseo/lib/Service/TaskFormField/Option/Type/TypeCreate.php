<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type;

use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateAbstract;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateCreate;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationCreateExecute;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationExecuteAbstract;

class TypeCreate extends TypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "create",
        protected ?TemplateAbstract $template = new TemplateCreate(new RepositoryIblockProperty(), new ServiceParseIncorrectText()),
        protected ?StrategyOperationExecuteAbstract $operation = new StrategyOperationCreateExecute(new RepositoryIblockProperty())
    )
    {
        parent::__construct($name, $code, $this->template, $this->operation);
    }
}