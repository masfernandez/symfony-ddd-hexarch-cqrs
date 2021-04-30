<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Command;

use Exception;
use Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser\NewUserCommand;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserAlreadyExists;
use Masfernandez\Shared\Domain\Model\DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateUserCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'app:create-user';

    public function __construct(private MessageBusInterface $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->commandBus->dispatch(
                new NewUserCommand(
                    $input->getArgument('email'),
                    $input->getArgument('password')
                )
            );
        } catch (Exception $exception) {
            $transactional = $exception->getPrevious();
            if (!$transactional instanceof DomainException) {
                $output->writeln('Unexpected error: ' . $transactional->getMessage());
                return Command::FAILURE;
            }

            $domainException = $transactional->getPrevious();

            $response = match (true) {
                $domainException instanceof UserAlreadyExists => 'User already exists in database.',
                default => 'Unexpected error: ' . $domainException->getMessage()
            };

            $output->writeln($response);
            return Command::FAILURE;
        }

        $output->writeln('User successfully generated!');
        return Command::SUCCESS;
    }
}
