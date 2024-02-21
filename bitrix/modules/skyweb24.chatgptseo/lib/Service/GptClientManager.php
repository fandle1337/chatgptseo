<?php

namespace Skyweb24\ChatgptSeo\Service;

use Exception;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Exception\ExceptionHttpClient;

use Skyweb24\ChatgptSeo\Repository\RepositorySetting;
use Skyweb24\ChatgptSeo\Service\Api\Module\Client;
use Skyweb24\ChatgptSeo\Service\ChatGpt\ContextMessage;
use Skyweb24\ChatgptSeo\Service\ChatGpt\ContextMessageCollection;
use Skyweb24\ChatgptSeo\Service\ChatGpt\EnumRole;
use Skyweb24\ChatgptSeo\Service\ChatGpt\GptClient;

class GptClientManager
{
    public function __construct(
        protected RepositorySetting $repositorySetting,
        protected Client            $moduleClient,
        protected GptClient         $gptClient
    )
    {
    }

    /**
     * @throws ExceptionHttpClient
     */
    public function prompt(string $text, int $taskId, int $elementId): ?string
    {
        if ($this->repositorySetting->getValue(EnumSettingApp::PERSONAL_CHAT_GPT_KEY_ACTIVE) === "Y") {
            $gptModel = $this->repositorySetting->getValue(EnumSettingApp::PERSONAL_GPT_MODEL);
            $collection = new ContextMessageCollection();
            $collection->push(
                new ContextMessage($text, EnumRole::ROLE_USER, 0)
            );

            return $this->gptClient->prompt($collection, $gptModel);
        }

        $gptModel = $this->repositorySetting->getValue(EnumSettingApp::GPT_MODEL);
        return $this->moduleClient->prompt($text, $taskId, $elementId, $gptModel);
    }
}