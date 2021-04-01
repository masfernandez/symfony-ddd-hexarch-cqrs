<?php

namespace Masfernandez\MusicLabelApp\Infrastructure\Backend\Command;

use Exception;
use Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser\NewUserCommand;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserAlreadyExists;
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
            $prevEx = $exception->getPrevious();
            if ($prevEx instanceof UserAlreadyExists) {
                //@todo message here...
                $output->writeln('Error when creating a new User. Message:' . PHP_EOL . $prevEx->getMessage());
                return Command::FAILURE;
            }
            $output->writeln($exception->getMessage(), OutputInterface::VERBOSITY_DEBUG);
            return Command::FAILURE;
        }

        $output->writeln('User successfully generated!');
        return Command::SUCCESS;
    }
}
