<?php

namespace Skyweb24\ChatgptSeo\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\Web\Json;
use Exception;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Dto\DtoIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Dto\DtoTaskAdvanced;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Enum\EnumStatus;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Service\Generator\Template\TemplateAbstract;
use Skyweb24\ChatgptSeo\Service\Operation\TaskOperationExecute;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;
use Skyweb24\ChatgptSeo\Service\TaskFormField\Field\FieldType;

class ServiceTaskOperationManager
{
    public function __construct(
        protected AggregatorTaskAdvanced          $dtoTaskAdvanced,
        protected GptClientManager                $gptClientManager,
        protected AggregatorIblockElementAdvanced $aggregatorIblockElementAdvanced,
        protected ServiceTaskElementUpdate        $serviceTaskElementUpdate,
    )
    {
    }

    /**
     * @throws ObjectNotFoundException
     */
    public function makeAll(DtoTaskAdvanced $dtoTaskAdvanced): bool
    {
        foreach ($dtoTaskAdvanced->elements as $dtoTaskElement) {

            $dtoIblockElementAdvanced = $this->aggregatorIblockElementAdvanced
                ->getById($dtoTaskElement->element_id);

            sleep(3);

            try {
                $this->make($dtoTaskAdvanced, $dtoIblockElementAdvanced);
            } catch (ExceptionHttpClient $e) {
                Debug::dumpToFile(
                    sprintf("%s - %s; %s", date("Y-m-d H:i:s"), $e->getMessage(), $e->getContext()),
                    EnumSettingApp::LOG_CODE_GPT_CLIENT_ERROR,
                    EnumSettingApp::LOG_PATH
                );

                $this->serviceTaskElementUpdate->update($dtoTaskElement->id, [
                    'status_id' => EnumStatus::ERROR,
                ]);

                continue;
            }


            $this->serviceTaskElementUpdate
                ->update($dtoTaskElement->id, [
                    'status_id' => EnumStatus::DONE,
                ]);

        }

        return true;
    }


    /**
     * @throws ExceptionHttpClient
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public function make(DtoTaskAdvanced $dtoTaskAdvanced, DtoIblockElementAdvanced $dtoIblockElementAdvanced): bool
    {
        $fieldOptionType = ServiceLocator::getInstance()
            ->get(FieldType::class)
            ->getOptionByCode($dtoTaskAdvanced->operation_type);

        $answerChatGpt = $this->getAnswerChatGpt(
            $this->buildText($fieldOptionType->getTemplate(), $dtoTaskAdvanced, $dtoIblockElementAdvanced),
            $dtoTaskAdvanced->id,
            $dtoIblockElementAdvanced->dtoIblockElement->id,
        );

        $strategyOperation = $fieldOptionType->getStrategy();
        $serviceTaskOperationExecute = new TaskOperationExecute(
            $strategyOperation,
            new RepositoryIblockElement(),
            new RepositoryIblockProperty()
        );

        return $serviceTaskOperationExecute->make(
            $dtoTaskAdvanced,
            $answerChatGpt,
            $dtoIblockElementAdvanced->dtoIblockElement->id
        );
    }

    protected function buildText(
        TemplateAbstract         $templateOperation,
        DtoTaskAdvanced          $dtoTaskAdvanced,
        DtoIblockElementAdvanced $dtoIblockElementAdvanced
    ): string
    {
        return $templateOperation
            ->buildTemplate(
                $dtoTaskAdvanced->operations,
                $dtoTaskAdvanced->element_type,
                $dtoTaskAdvanced->incorrect_text,
                $dtoIblockElementAdvanced
            );
    }


    /**
     * @throws ExceptionHttpClient
     */
    public function getAnswerChatGpt(string $text, int $taskId, int $elementId): ?array
    {
        try {
            $answerChatGpt = $this->gptClientManager->prompt($text, $taskId, $elementId);
            $answerChatGpt = preg_replace('/```json|```/', '', $answerChatGpt);
            $answerChatGpt = preg_replace('/\n\s+/', ' ', $answerChatGpt);

            return Json::decode(
                mb_convert_encoding($answerChatGpt, 'utf-8', LANG_CHARSET)
            );
        } catch (ArgumentException $e) {
            throw new ExceptionHttpClient($e->getMessage(), $text);
        }
    }
}