<?php
declare(strict_types = 1);

return [
    'typo3-redirects-updater:replace-source-host' => [
        'class'       => \Supseven\RedirectsUpdater\Command\ReplaceSourceHostCommand::class,
        'schedulable' => false,
    ],
];
