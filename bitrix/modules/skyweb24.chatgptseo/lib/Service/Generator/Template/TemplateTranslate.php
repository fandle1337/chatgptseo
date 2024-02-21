<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Template;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldElementType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldInput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldLanguage;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\FactoryOptionInput;

class TemplateTranslate extends TemplateAbstract
{
    protected function buildRole(): string
    {
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_ROLE");
    }

    protected function buildObject(string $elementType, DtoIblockElementAdvanced $dto): string
    {
        $fieldTypeName = (new FieldElementType())->getOptionByCode($elementType);
        $typeName = $fieldTypeName->getName();
        if ($fieldTypeName->getCode() === 'product') { // TODO refactor
            return sprintf(
                '%s %s "%s"',
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_BUILD_OBJECT_MALE"),
                strtolower($typeName),
                $dto->dtoIblockElement->name
            );
        } else {
            return sprintf(
                '%s %s "%s"',
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_BUILD_OBJECT"),
                strtolower($typeName),
                $dto->dtoIblockElement->name
            );
        }
    }

    protected function buildAction(string $elementType, array $operations): string
    {
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_ACTION");
    }

    protected function buildOperation(array $operations, DtoIblockElementAdvanced $dto): string
    {
        $rows = [];
        foreach ($operations as $operation) {
            /** @var FieldInput $fieldInput */
            $fieldInput = ServiceLocator::getInstance()
                ->get(FieldInput::class)
                ->setOptionList(
                    FactoryOptionInput::make(
                        $this->getPropertyList($dto->dtoIblockElement->iblockId)
                    )
                );

            /** @var FieldOutput $fieldOutput */
            $fieldOutput = ServiceLocator::getInstance()
                ->get(FieldOutput::class)
                ->setOptionList(
                    FactoryOptionInput::make(
                        $this->getPropertyList($dto->dtoIblockElement->iblockId)
                    )
                );

            $fieldLanguage = new FieldLanguage();

            $inputValue = $operation[$fieldInput->getCode()];
            $outputValue = $operation[$fieldOutput->getCode()];
            $languageValue = $operation[$fieldLanguage->getCode()];

            $fieldInputOption = $fieldInput->getOptionByCode($inputValue);
            $fieldOutputOption = $fieldOutput->getOptionByCode($outputValue);
            $fieldLanguageOption = $fieldLanguage->getOptionByCode($languageValue);

            if (!$value = $fieldInputOption->getDtoIblockElementValue($dto)) {
                continue;
            }

            $rows[] = sprintf('"%s": "%s" %s %s',
                $fieldOutputOption->getCode(),
                $value,
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_OPERATION"),
                strtolower($fieldLanguageOption->getName())
            );
        }

        return implode("\n", $rows) . "\n";

    }

    protected function buildAnswerFormat(array $operations, DtoIblockElementAdvanced $dto): string
    {
        foreach ($operations as $operation) {
            $fieldOutput = new FieldOutput();
            $result[] = $operation[$fieldOutput->getCode()];
        }
        return $this->formatForQueryAnswer($result ?? []);
    }

    private function formatForQueryAnswer(array $array): string
    {
        $result = '';
        foreach ($array as $item) {
            $result .= sprintf
            (
                '%s -> %s%s',
                $item,
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_TRANSLATE_KEY_TEXT"),
                "\n"
            );
        }
        return $result;
    }
}