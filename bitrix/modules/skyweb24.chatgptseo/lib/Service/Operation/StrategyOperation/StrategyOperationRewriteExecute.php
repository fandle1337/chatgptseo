<?php

namespace Skyweb24\ChatgptSeo\Service\Operation\StrategyOperation;

use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FactoryFieldOutput;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputH1;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputIblockProperty;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaDescription;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaKeywords;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Option\Output\OutputMetaTitle;

class StrategyOperationRewriteExecute extends StrategyOperationExecuteAbstract
{
    public function make(array $chatGptAnswer, array $operation, int $iblockId): array
    {
        $fieldOutput = FactoryFieldOutput::make($this->getPropertyList($iblockId));
        $fieldOutputOption = $fieldOutput->getOptionByCode($operation[$fieldOutput->getCode()]);
        $text = $this->getGptOutputText($chatGptAnswer, $fieldOutputOption);
        //TODO refactor

//        $fieldOutputOption->setValue($text);
//        return $fieldOutputOption;

        if (
            $fieldOutputOption instanceof OutputMetaTitle ||
            $fieldOutputOption instanceof OutputMetaKeywords ||
            $fieldOutputOption instanceof OutputMetaDescription ||
            $fieldOutputOption instanceof OutputH1
        ) {
            $data['IPROPERTY_TEMPLATES'][$fieldOutputOption->getCode()] = $text;
        } elseif ($fieldOutputOption instanceof OutputIblockProperty) {
            $data['PROPERTY_VALUES'][$fieldOutputOption->getCode()] = $text;
        } else {
            $data[$fieldOutputOption->getCode()] = $text;
        }
        return $data;
    }

    private function getGptOutputText(array $chatGptAnswer, $option): string
    {
        return $chatGptAnswer[$option->getCode()];
    }
}