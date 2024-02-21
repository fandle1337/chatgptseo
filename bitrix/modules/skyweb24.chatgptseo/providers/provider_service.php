<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Web\HttpClient;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Cache\ServiceAiModelCache;
use Skyweb24\ChatgptSeo\Cache\ServiceCheckProxyCache;
use Skyweb24\ChatgptSeo\Cache\ServiceClientCache;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryUser;
use Skyweb24\ChatgptSeo\Service\Api\Module\Client;
use Skyweb24\ChatgptSeo\Service\Generator\Pattern\ServiceParseIncorrectText;
use Skyweb24\ChatgptSeo\Service\GptClientManager;
use Skyweb24\ChatgptSeo\Service\ServiceAiModel;
use Skyweb24\ChatgptSeo\Service\ServiceCheckElement;
use Skyweb24\ChatgptSeo\Service\ServiceCheckIblock;
use Skyweb24\ChatgptSeo\Service\ServiceCheckProxy;
use Skyweb24\ChatgptSeo\Service\ServiceTaskOperationManager;
use Skyweb24\ChatgptSeo\Service\Statistics\Fill\ServiceFillDate;
use Skyweb24\ChatgptSeo\Service\Statistics\Fill\ServiceFillName;
use Skyweb24\ChatgptSeo\Service\Statistics\ServiceCountTotalSpent;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskCreate;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskDelete;
use Skyweb24\ChatgptSeo\Service\Task\ServiceTaskUpdate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementCreate;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementDelete;
use Skyweb24\ChatgptSeo\Service\TaskElement\ServiceTaskElementUpdate;

return [
    ServiceCountTotalSpent::class      => [
        "className"         => ServiceCountTotalSpent::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    ServiceFillName::class             => [
        "className"         => ServiceFillName::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
                ServiceLocator::getInstance()->get(RepositoryUser::class),
            ];
        },
    ],
    ServiceFillDate::class             => [
        "className"         => ServiceFillDate::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
                ServiceLocator::getInstance()->get(RepositoryUser::class),
            ];
        },
    ],
    ServiceParseIncorrectText::class   => [
        "className"         => ServiceParseIncorrectText::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    ServiceTaskOperationManager::class => [
        "className"         => ServiceTaskOperationManager::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(AggregatorTaskAdvanced::class),
                ServiceLocator::getInstance()->get(GptClientManager::class),
                ServiceLocator::getInstance()->get(AggregatorIblockElementAdvanced::class),
                ServiceLocator::getInstance()->get(ServiceTaskElementUpdate::class),
            ];
        },
    ],
    ServiceTaskUpdate::class           => [
        "className"         => ServiceTaskUpdate::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
            ];
        },
    ],
    ServiceTaskCreate::class           => [
        "className"         => ServiceTaskCreate::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
            ];
        },
    ],
    ServiceTaskDelete::class           => [
        "className"         => ServiceTaskDelete::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
            ];
        },
    ],
    ServiceTaskElementUpdate::class    => [
        "className"         => ServiceTaskElementUpdate::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
            ];
        },
    ],
    ServiceTaskElementCreate::class    => [
        "className"         => ServiceTaskElementCreate::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
            ];
        },
    ],
    ServiceTaskElementDelete::class    => [
        "className"         => ServiceTaskElementDelete::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
            ];
        },
    ],
    ServiceCheckProxy::class           => [
        "className"         => ServiceCheckProxy::class,
        "constructorParams" => static function () {
            return [
                new HttpClient(),
            ];
        },
    ],
    ServiceAiModel::class              => [
        "className"         => ServiceAiModel::class,
        "constructorParams" => static function () {
            return [
                new HttpClient(),
            ];
        },
    ],
    ServiceCheckProxyCache::class      => [
        "className"         => ServiceCheckProxyCache::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(ServiceCheckProxy::class),
                900
            ];
        },
    ],
    ServiceAiModelCache::class         => [
        "className"         => ServiceAiModelCache::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(ServiceAiModel::class),
                900
            ];
        },
    ],
    ServiceClientCache::class          => [
        "className"         => ServiceClientCache::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(Client::class),
                180
            ];
        },
    ],
    ServiceCheckElement::class         => [
        "className"         => ServiceCheckElement::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class)
            ];
        },
    ],
    ServiceCheckIblock::class          => [
        "className"         => ServiceCheckIblock::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
                ServiceLocator::getInstance()->get(RepositoryTask::class),
            ];
        },
    ],
];