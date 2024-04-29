<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title'       => 'redirects_updater',
    'description' => 'Easily replace the source_host of existing TYPO3 redirects',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Supseven\\RedirectsUpdater\\' => 'Classes/',
        ],
    ],
];
