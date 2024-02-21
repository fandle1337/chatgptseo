<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Template;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;

abstract class TemplateAbstract
{
    protected string $template;

    public function __construct(
        protected RepositoryIblockProperty  $repositoryIblockProperty,
        protected ServiceParseIncorrectText $serviceParseIncorrectText,
    )
    {
        $this->template = Loc::getMessage('SKYWEB24_CHATGPTSEO_TEMPLATE_ABSTRACT_CONSTRUCT');
    }

    public function getPropertyList(int $iblockId): array
    {
        return $this->repositoryIblockProperty->getById($iblockId, ["S"]);
    }

    public function parseIncorrectText(string $incorrectText, DtoIblockElementAdvanced $dto): string|bool
    {
        return $this->serviceParseIncorrectText->getResult($incorrectText, $dto);
    }

    abstract protected function buildRole(): string;

    abstract protected function buildObject(string $elementType, DtoIblockElementAdvanced $dto): string;

    abstract protected function buildAction(string $elementType, array $operations): string;

    abstract protected function buildOperation(array $operations, DtoIblockElementAdvanced $dto): string;

    protected function buildAddInformation(?string $incorrectText, DtoIblockElementAdvanced $dto): string|bool
    {
        if (strlen($incorrectText) == 0) {
            return false;
        }

        return sprintf(
            Loc::getMessage('SKYWEB24_CHATGPTSEO_TEMPLATE_ABSTRACT_TEMPLATE_INFORMATION'),
            Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_ABSTRACT_ADD_INFORMATION"),
            $this->parseIncorrectText($incorrectText, $dto) ?: $incorrectText
        );
    }

    abstract protected function buildAnswerFormat(array $operations, DtoIblockElementAdvanced $dto): string;

    final public function buildTemplate(array $operations, string $elementType, ?string $incorrectText, DtoIblockElementAdvanced $dto): string
    {
        return sprintf(
            $this->template,
            $this->buildRole(),
            $this->buildObject($elementType, $dto),
            $this->buildAction($elementType, $operations),
            $this->buildOperation($operations, $dto),
            $this->buildAddInformation($incorrectText, $dto) ?: '',
            $this->buildAnswerFormat($operations, $dto),
        );
    }
}
