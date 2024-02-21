<?php

use Skyweb24\ChatgptSeo\Model\ModelTaskElementsTable;
use Skyweb24\ChatgptSeo\Model\ModelTasksTable;
use Skyweb24\ChatgptSeo\Repository\RepositoryAgent;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblock;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockProperty;
use Skyweb24\ChatgptSeo\Repository\RepositoryIblockSection;
use Skyweb24\ChatgptSeo\Repository\RepositoryPrice;
use Skyweb24\ChatgptSeo\Repository\RepositorySetting;
use Skyweb24\ChatgptSeo\Repository\RepositoryTask;
use Skyweb24\ChatgptSeo\Repository\RepositoryTaskElement;
use Skyweb24\ChatgptSeo\Repository\RepositoryUser;

return [
    RepositorySetting::class       => [
        "className"         => RepositorySetting::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryTaskElement::class   => [
        "className"         => RepositoryTaskElement::class,
        "constructorParams" => static function () {
            return [
                new ModelTaskElementsTable(),
            ];
        },
    ],
    RepositoryTask::class          => [
        "className"         => RepositoryTask::class,
        "constructorParams" => static function () {
            return [
                new ModelTasksTable(),
            ];
        },
    ],
    RepositoryAgent::class         => [
        "className"         => RepositoryAgent::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryUser::class          => [
        "className"         => RepositoryUser::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryIblockSection::class => [
        "className"         => RepositoryIblockSection::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryIblock::class => [
        "className"         => RepositoryIblock::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryPrice::class => [
        "className"         => RepositoryPrice::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryIblockProperty::class => [
        "className"         => RepositoryIblockProperty::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
    RepositoryIblockElement::class => [
        "className"         => RepositoryIblockElement::class,
        "constructorParams" => static function () {
            return [];
        },
    ],
];