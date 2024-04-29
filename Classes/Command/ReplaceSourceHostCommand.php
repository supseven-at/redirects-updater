<?php

declare(strict_types=1);

namespace Supseven\RedirectsUpdater\Command;

use Doctrine\DBAL\DBALException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

/**
 * Class ReplaceSourceHostCommand
 *
 * @author Josef Glatz <j.glatz@supseven.at>
 */
class ReplaceSourceHostCommand extends Command
{
    private QueryBuilder $redirectQuery;

    public function __construct(QueryBuilder $redirectQuery)
    {
        $this->redirectQuery = $redirectQuery;
        parent::__construct();
    }

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

    /**
     * @throws DBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queryBuilder = $this->redirectQuery;

        $updateQuery = $queryBuilder
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
            ->executeStatement();

        if ($updateQuery > 0) {
            $output->writeln('<info>Updated ' . $updateQuery . ' redirects from source_host ' .  $input->getArgument('from') . ' → ' . $input->getArgument('to') . '.</info>');
        }

        $output->writeln('<info>Please run "./typo3cms redirects:checkintegrity" to check resulting redirects for problems.</info>');

        return Command::SUCCESS;
    }
}
