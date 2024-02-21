<?php

namespace Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Type;

use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateAbstract;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateRewrite;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationExecuteAbstract;
use Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation\StrategyOperationRewriteExecute;

class TypeRewrite extends TypeAbstract
{
    public function __construct(
        ?string $name,
        ?string $code = "rewrite",
        protected ?TemplateAbstract $template = new TemplateRewrite(new RepositoryIblockProperty(), new ServiceParseIncorrectText()),
        protected ?StrategyOperationExecuteAbstract $operation = new StrategyOperationRewriteExecute(new RepositoryIblockProperty())
    )
    {
        parent::__construct($name, $code, $this->template, $this->operation);
    }
}