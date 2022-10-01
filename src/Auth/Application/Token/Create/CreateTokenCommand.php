<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Query\Query;
use Masfernandez\ValueObject\Exception\ValueObjectException;

final class CreateTokenCommand implements Query
{
    private readonly UserEmail $email;
    private readonly UserPassword $password;

    /**
     * @throws ValueObjectException
     */
    public function __construct(string $email, string $password)
    {
        $this->email    = new UserEmail($email);
        $this->password = new UserPassword($password);
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
