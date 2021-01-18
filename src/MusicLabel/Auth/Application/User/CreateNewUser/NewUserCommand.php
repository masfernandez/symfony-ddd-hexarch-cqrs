<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser;

use Masfernandez\Shared\Domain\Bus\Command\CommandInterface;

final class NewUserCommand implements CommandInterface
{
    public function __construct(private string $email, private string $password)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}