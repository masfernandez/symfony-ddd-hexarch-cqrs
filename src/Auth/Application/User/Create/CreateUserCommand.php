<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;
use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;
use Masfernandez\ValueObject\ValueObjectException;

final class CreateUserCommand implements Command
{
    private readonly UserId $id;
    private readonly UserEmail $email;
    private readonly UserPassword $password;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $uuid,
        string $email,
        string $password,
    ) {
        $this->id       = new UserId($uuid);
        $this->email    = new UserEmail($email);
        $this->password = new UserPassword(password_hash($password, PASSWORD_ARGON2ID));
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }
}
