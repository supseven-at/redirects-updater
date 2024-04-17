<?php

declare(strict_types = 1);
namespace Supseven\RedirectsUpdater\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ReplaceSourceHostCommand
 *
 * @author Josef Glatz <j.glatz@supseven.at>
 */
class ReplaceSourceHostCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Replace existing source host with a new source host value');
        $this->addArgument(
            'from',
            InputArgument::REQUIRED,
            'Existing source_host value which should be replaces by new one'
        );
        $this->addArgument(
            'to',
            InputArgument::REQUIRED,
            'New source_host value which should replace the existing value set in argument "from"'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_redirect');

        $queryBuilder
            ->update('sys_redirect')
            ->where(
                $queryBuilder->expr()->eq(
                    'sys_redirect.source_host',
                    $queryBuilder->createNamedParameter(
                        $input->getArgument('from')
                    )
                )
            )
            ->set(
                'sys_redirect.source_host',
                $input->getArgument('to')
            )
            ->execute();

        return 0;
    }
}
