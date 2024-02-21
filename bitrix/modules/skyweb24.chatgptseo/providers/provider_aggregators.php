<?php

use Bitrix\Main\DI\ServiceLocator;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorIblockElementAdvanced;
use Skyweb24\ChatgptSeo\Aggregator\AggregatorTaskAdvanced;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElementSeoProperty;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;

return [
    AggregatorIblockElementAdvanced::class => [
        "className"         => AggregatorIblockElementAdvanced::class,
        "constructorParams" => static function () {
            return [
                new RepositoryIblockElement(),
                new RepositoryIblockElementSeoProperty(),
            ];
        },
    ],
    AggregatorTaskAdvanced::class          => [
        "className"         => AggregatorTaskAdvanced::class,
        "constructorParams" => static function () {
            return [
                ServiceLocator::getInstance()->get(RepositoryTask::class),
                ServiceLocator::getInstance()->get(RepositoryTaskElement::class),
            ];
        },
    ],
];