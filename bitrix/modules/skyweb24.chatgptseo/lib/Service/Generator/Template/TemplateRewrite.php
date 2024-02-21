<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Template;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FactoryFieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldElementType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldInput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Input\FactoryOptionInput;

class TemplateRewrite extends TemplateAbstract
{
    protected function buildRole(): string
    {
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_REWRITE_ROLE");
    }

    protected function buildObject(string $elementType, DtoIblockElementAdvanced $dto): string
    {
        $fieldTypeName = (new FieldElementType())->getOptionByCode($elementType);
        $typeName = $fieldTypeName->getName();
        if ($fieldTypeName->getCode() === 'product') { // TODO refactor
            return sprintf(
                '%s %s "%s"',
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_REWRITE_BUILD_OBJECT_MALE"),
                strtolower($typeName),
                $dto->dtoIblockElement->name
            );
        } else {
            return sprintf(
                '%s %s "%s"',
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_REWRITE_BUILD_OBJECT"),
                strtolower($typeName),
                $dto->dtoIblockElement->name
            );
        }
    }

    protected function buildAction(string $elementType, array $operations): string
    {
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_REWRITE_ACTION");
    }


    protected function buildOperation(array $operations, DtoIblockElementAdvanced $dto): string
    {
        foreach ($operations as $operation) {
            $rows = [];
            foreach ($operation as $key => $value) {

                $fieldInput = ServiceLocator::getInstance()
                    ->get(FieldInput::class)
                    ->setOptionList(
                        FactoryOptionInput::make(
                            $this->getPropertyList($dto->dtoIblockElement->iblockId)
                        )
                    );

                $fieldOutput = ServiceLocator::getInstance()
                    ->get(FieldOutput::class)
                    ->setOptionList(
                        FactoryOptionInput::make(
                            $this->getPropertyList($dto->dtoIblockElement->iblockId)
                        )
                    );

                $outputValue = $operation[$fieldOutput->getCode()];
                $inputValue = $operation[$fieldInput->getCode()];

                $fieldOutputOption = $fieldOutput->getOptionByCode($outputValue);
                $fieldInputOption = $fieldInput->getOptionByCode($inputValue);

                if (!$value = $fieldInputOption->getDtoIblockElementValue($dto)) {
                    continue;
                }
                $rows[$fieldOutputOption->getCode()] = $value;
            }
            $result[] = $rows;
        }
        return $this->formatForQueryOperation($result ?? []);
    }

    protected function buildAnswerFormat(array $operations, DtoIblockElementAdvanced $dto): string
    {
        foreach ($operations as $operation) {
            $fieldOutput = FactoryFieldOutput::make($this->getPropertyList($dto->dtoIblockElement->iblockId));
            $result[] = $operation[$fieldOutput->getCode()];
        }
        return $this->formatForQueryAnswer($result ?? []);
    }

    private function formatForQueryOperation(array $array): string
    {
        $result = '';
        foreach ($array as $item) {
            foreach ($item as $key => $value) {
                $result .= sprintf('"%s": "%s"%s', $key, $value, "\n");
            }
        }
        return $result;
    }

    private function formatForQueryAnswer(array $array): string
    {
        $result = '';
        foreach ($array as $item) {
            $result .= sprintf
            (
                '%s -> %s%s',
                $item,
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_REWRITE_KEY_TEXT"),
                "\n"
            );
        }
        return $result;
    }
}
