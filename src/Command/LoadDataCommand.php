<?php

namespace App\Command;

use App\Entity\Account;
use App\Entity\Team;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Faker;

class LoadDataCommand extends Command
{
    protected static $defaultName = 'app:load-data';
    protected static $defaultDescription = 'Insert Account and Team datum';

    private int $accountsCount;
    private int $teamsCount;
    private Faker\Generator $faker;
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->faker = Faker\Factory::create('fr-FR');
        $this->manager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('accounts', null, InputOption::VALUE_OPTIONAL, 'Accounts count')
            ->addOption('teams', null, InputOption::VALUE_OPTIONAL, 'Teams counts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->teamsCount = $input->getOption('teams') ?? 1;
        $this->accountsCount = $input->getOption('accounts') ?? 1;

        if ($input->getOption('accounts')) {
            $io->note(sprintf('You passed accounts count: %s', $input->getOption('accounts')));
        } else {
            $io->note(sprintf('For accounts count is passed: %s', 1));
        }

        if ($input->getOption('teams')) {
            $io->note(sprintf('You passed an teams count: %s', $input->getOption('teams')));
        } else {
            $io->note(sprintf('For teams count is passed: %s', 1));
        }

        for ($i = 0; $i < $this->teamsCount; $i++) {
            $this->addTeams();
        }
        $this->manager->flush();

        for ($i = 0; $i < $this->accountsCount; $i++) {
            $this->addAccounts();
        }

        $this->manager->flush();

        $io->success('Data loading is finished.');

        return Command::SUCCESS;
    }

    private function addTeams(): void
    {
        $team = new Team();
        $team->setName($this->faker->word());
        $this->manager->persist($team);
    }

    private function addAccounts(): void
    {

        $teams = $this->manager->getRepository(Team::class)->findAll();
        shuffle($teams);

        $account = new Account();
        $account->setName($this->faker->name());
        $account->setTeam($teams[0]);
        $this->manager->persist($account);
    }
}
