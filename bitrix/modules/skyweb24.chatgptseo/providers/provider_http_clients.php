<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\License;
use Skyweb24\ChatgptSeo\Enum\EnumSettingApp;
use Skyweb24\ChatgptSeo\Repository\RepositorySetting;
use Skyweb24\ChatgptSeo\Service\ChatGpt\GptClient;
use Skyweb24\ChatgptSeo\Service\Api;
use Skyweb24\ChatgptSeo\Service\GptClientManager;

return [
    GptClient::class                                    => [
        "className"         => GptClient::class,
        "constructorParams" => static function () {

            $httpClient = new Bitrix\Main\Web\HttpClient();
            $httpClient->setTimeout(120);
            $httpClient->setHeader('Content-Type', "application/json");
            $httpClient->setProxy(
                ServiceLocator::getInstance()->get(RepositorySetting::class)
                    ->getValue(EnumSettingApp::PERSONAL_PROXY_ADDRESS),
                (int)ServiceLocator::getInstance()->get(RepositorySetting::class)
                    ->getValue(EnumSettingApp::PERSONAL_PROXY_PORT),
                ServiceLocator::getInstance()->get(RepositorySetting::class)
                    ->getValue(EnumSettingApp::PERSONAL_PROXY_LOGIN),
                ServiceLocator::getInstance()->get(RepositorySetting::class)
                    ->getValue(EnumSettingApp::PERSONAL_PROXY_PASSWORD)
            );

            $token = ServiceLocator::getInstance()->get(RepositorySetting::class)->getValue(
                EnumSettingApp::PERSONAL_CHAT_GPT_KEY
            );

            return [
                $httpClient,
                $token,
            ];
        },
    ],
    Api\Module\Client::class                            => [
        "className"         => Api\Module\Client::class,
        "constructorParams" => static function () {

            $httpClient = new Bitrix\Main\Web\HttpClient();
            $httpClient->setHeader('Content-Type', "application/json");
            $httpClient->setTimeout(120);

            return [
                $httpClient,
                (new License)->getKey(),
                EnumSettingApp::MODULE_CODE,
            ];
        },
    ],
    \Skyweb24\ChatGptSeo\Core\Service\Api\Client::class => [
        "className"         => \Skyweb24\ChatGptSeo\Core\Service\Api\Client::class,
        "constructorParams" => static function () {

            $httpClient = new Bitrix\Main\Web\HttpClient();
            $httpClient->setHeader('Content-Type', "application/json");
            $httpClient->setTimeout(120);

            return [
                $httpClient,
                (new License)->getKey(),
                EnumSettingApp::MODULE_CODE,
                $_SERVER['SERVER_NAME']
            ];
        },
    ],
    GptClientManager::class                             => [
        "className"         => GptClientManager::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositorySetting::class),
                ServiceLocator::getInstance()->get(Api\Module\Client::class),
                ServiceLocator::getInstance()->get(GptClient::class),
            ];
        },
    ],
];