<?php

namespace Skyweb24\ChatgptSeo\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use Skyweb24\ChatgptSeo\Enum\EnumAiModel;
use Skyweb24\ChatgptSeo\Interface\InterfaceServiceAiModel;

class ServiceAiModel implements InterfaceServiceAiModel
{
    public function __construct(
        protected HttpClient $httpClient,
    )
    {
    }

    public function getList(string $key, array $proxySettings): array|false
    {
        $this->httpClient
            ->setHeader('Authorization', 'Bearer ' . $key)
            ->setProxy(
                $proxySettings['address'],
                $proxySettings['port'],
                $proxySettings['login'],
                $proxySettings['password']
            );
        $response = $this->httpClient->get("https://api.openai.com/v1/models");

        try {
            $response = JSON::decode($response);
        } catch (ArgumentException $e) {
            return false;
        }

        if (!empty($response['error'])) {
            return false;
        }

        return $this->extractByModelList($response['data']);
    }

    protected function extractByModelList(array $aiModelList): array
    {
        foreach ($aiModelList as $model) {
            if ($model['id'] === EnumAiModel::GPT_3_5_TURBO->value ||
                $model['id'] === EnumAiModel::GPT_4_5_TURBO->value)
            {
                $result[] = $model;
            }
        }

        return $result ?? [];
    }
}