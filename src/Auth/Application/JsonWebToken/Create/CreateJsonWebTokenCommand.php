<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\ValueObject\Exception\ValueObjectException;

final class CreateJsonWebTokenCommand implements Request
{
    private readonly UserEmail $email;
    private readonly UserPassword $password;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $email,
        string $password,
    ) {
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
