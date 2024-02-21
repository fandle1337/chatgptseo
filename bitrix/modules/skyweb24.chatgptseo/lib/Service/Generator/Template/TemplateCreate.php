<?php

namespace Skyweb24\ChatgptSeo\Service\Generator\Template;

use Bitrix\Main\Localization\Loc;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FactoryField;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldElementType;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldEntity;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldFeature;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldLength;

class TemplateCreate extends TemplateAbstract
{
    protected function buildRole(): string
    {
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_CREATE_ROLE");
    }

    protected function buildObject(string $elementType, DtoIblockElementAdvanced $dto): string
    {
        $fieldTypeName = (new FieldElementType())->getOptionByCode($elementType);
        $typeName = $fieldTypeName->getName();
        if ($fieldTypeName->getCode() === 'product') { // TODO refactor
            return sprintf(
                '%s %s "%s"',
                Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_CREATE_BUILD_OBJECT_MALE"),
                strtolower($typeName),
                $dto->dtoIblockElement->name
            );
        }
        return sprintf(
            '%s %s "%s"',
            Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_CREATE_BUILD_OBJECT"),
            strtolower($typeName),
            $dto->dtoIblockElement->name
        );
    }

    protected function buildAction(string $elementType, array $operations): string
    {
        $fieldTypeName = (new FieldElementType())->getOptionByCode($elementType);
        if ($fieldTypeName->getCode() === 'product') { // TODO refactor
            return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_CREATE_ACTION_MALE");
        }
        return Loc::getMessage("SKYWEB24_CHATGPTSEO_TEMPLATE_CREATE_ACTION");
    }

    protected function buildOperation(array $operations, DtoIblockElementAdvanced $dto): string
    {
        $result = [];
        foreach ($operations as $operation) {
            $row = [];
            foreach ($operation as $key => $value) {
                $field = FactoryField::makeByCode($key, [
                    new FieldEntity(),
                    new FieldLength(),
                    new FieldFeature(),
                ]);
                if (!empty($field)) {
                    $formatValue = $field->getValueForTemplate($value);
                    $row[] = $formatValue;
                }
            }
            $result[] = $row;
        }
        return $this->formatForQueryOperation($result);
    }

    protected function buildAnswerFormat(array $operations, DtoIblockElementAdvanced $dto): string
    {
        $list = [];
        foreach ($operations as $operation) {
            $fieldEntity = new FieldEntity();
            $fieldValue = $operation[$fieldEntity->getCode()];
            $list[] = [$fieldValue => $fieldEntity->getValueForTemplate($fieldValue)];
        }
        return $this->formatForQueryAnswer($list);
    }

    private function formatForQueryOperation(array $list): string
    {
        $result = '';
        foreach ($list as $row) {
            $result .= $row[0] . ' ';
            if (count($row) > 1) {
                $result .= '(' . implode(', ', array_slice($row, 1)) . "). \n";
            }
        }
        return $result;
    }

    private function formatForQueryAnswer(array $array): string
    {
        $result = '';
        foreach ($array as $item) {
            foreach ($item as $key => $value) {
                $result .= sprintf
                (
                    '%s -> %s%s',
                    $key,
                    $value,
                    "\n"
                );
            }
        }
        return $result;
    }
}