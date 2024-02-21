<?php

return [
    'controllers' => [
        'value'    => [
            'namespaces' => [
                '\\Skyweb24\\Chatgptseo\\Controller' => 'api',
            ],
        ],
        'readonly' => true,
    ],
    'services'    => [
        "value" => array_merge([],
            require_once "providers/provider_repository.php",
            require_once "providers/provider_http_clients.php",
            require_once "providers/provider_service.php",
            require_once "providers/provider_fields.php",
            require_once "providers/provider_options.php",
            require_once "providers/provider_aggregators.php",
            require_once "providers/provider_patterns.php",
        ),
    ],
];