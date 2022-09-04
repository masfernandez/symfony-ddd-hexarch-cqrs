<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;

final class NewUserCommand implements Command
{
    public function __construct(private readonly string $email, private readonly string $password)
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
