<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Command;

use Exception;
use Masfernandez\MusicLabel\Auth\Application\User\Create\CreateUserCommand as CreateUser;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Shared\Domain\DomainException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    aliases: ['app:create-user'],
    hidden: false
)]
class CreateUserCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
            ->addArgument('uuid', InputArgument::OPTIONAL, 'The uuid of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->commandBus->dispatch(
                new CreateUser(
                    uuid:     $input->getArgument('uuid') ?? Uuid::v4()->toRfc4122(),
                    email:    $input->getArgument('email'),
                    password: $input->getArgument('password'),
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
