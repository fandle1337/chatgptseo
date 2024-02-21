<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

// You can do your own things here, e.g. collecting symbols to expose dynamically
// or files to exclude.
// However beware that this file is executed by PHP-Scoper, hence if you are using
// the PHAR it will be loaded by the PHAR. So it is highly recommended to avoid
// to auto-load any code here: it can result in a conflict or even corrupt
// the PHP-Scoper analysis.

// Example of collecting files to include in the scoped build but to not scope
// leveraging the isolated finder.
$excludedFiles = array_map(
    static fn (SplFileInfo $fileInfo) => $fileInfo->getPathName(),
    iterator_to_array(
        Finder::create()->files()->in(__DIR__),
        false,
    ),
);

return [
    // The prefix configuration. If a non-null value is used, a random prefix
    // will be generated instead.
    //
    // For more see: https://github.com/humbug/php-scoper/blob/master/docs/configuration.md#prefix
    'prefix' => "Skyweb24\\ChatGptSeo",

    // The base output directory for the prefixed files.
    // This will be overridden by the 'output-dir' command line option if present.
    'output-dir' => "vendor-scope",

    'finders' => [
        Finder::create()
            ->files()
            ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/')
            ->exclude([
                'doc',
                'test',
                'test_old',
                'tests',
                'Tests',
                'vendor-bin',
            ])
            ->in('vendor'),
        Finder::create()->append([
            'composer.json',
        ])
    ],

    'exclude-namespaces' => [
        'Bitrix',
        '/regex/',
    ],
    'exclude-classes' => [
        'Bitrix',
        '/regex/',
        'CUpdateClientPartner',
        'CModule',
        'CAdminNotify'
    ],
];
