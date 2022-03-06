<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;

interface UserRepository
{
    public function getByEmail(UserEmail $email): ?User;

    // @todo not used
    public function getByEmailAndPassword(UserEmail $email, UserPassword $password): ?User;

    /** @throws UserAlreadyExists */
    public function post(User $user): void;
}
