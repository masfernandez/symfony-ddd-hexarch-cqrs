<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\User;

interface UserRepository
{
    public function getByEmail(UserEmail $email): ?User;

    // @todo not used
    public function getByEmailAndPassword(UserEmail $email, UserPassword $password): ?User;

    /** @throws UserAlreadyExistsException */
    public function post(User $user): void;
}