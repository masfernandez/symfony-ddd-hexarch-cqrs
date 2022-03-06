<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Query\Query;

final class GetTokenQuery implements Query
{
    private UserEmail $email;
    private UserPassword $password;

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
