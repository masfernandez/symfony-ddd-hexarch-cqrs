<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserPassword;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class GetJwtQuery implements Request
{
    private UserEmail $email;
    private UserPassword $password;

    public function __construct(string $email, string $password)
    {
        $this->email = new UserEmail($email);
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
