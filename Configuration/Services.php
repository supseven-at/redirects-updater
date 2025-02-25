<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Supseven\\RedirectsUpdater\\', __DIR__ . '/../Classes/*');

    $services->set('querybuilder.redirect', 'TYPO3\CMS\Core\Database\Query\QueryBuilder')
        ->factory([
            service('TYPO3\CMS\Core\Database\ConnectionPool'),
            'getQueryBuilderForTable',
        ])
        ->args([
            'sys_redirect',
        ]);

    $services->set('Supseven\RedirectsUpdater\Command\ReplaceSourceHostCommand')
        ->tag('console.command', [
            'command' => 'typo3-redirects-updater:replace-source-host',
            'description' => 'Replace existing source host with a new source host value',
        ])
        ->arg('$redirectQuery', service('querybuilder.redirect'));
};
