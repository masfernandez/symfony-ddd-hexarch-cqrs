<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;

interface UserRepository
{
    /** @throws UserAlreadyExists */
    public function add(User $user, bool $flush = true): void;

    public function remove(User $user, bool $flush = true): void;

    /** @throws UserNotFound */
    public function update(User $user, bool $flush = true): void;

    public function search(UserId $id): ?User;

    public function searchOneBy(array $criteria, array $orderBy = null): ?User;

    /** @return object[]|User[] */
    public function searchAll(): array;

    /** @return object[]|User[] */
    public function searchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    public function countBy(array $criteria): int;

    public function getByEmail(UserEmail $email): ?User;

    // @todo not used
    public function getByEmailAndPassword(UserEmail $email, UserPassword $password): ?User;

    public function searchByToken(TokenValue $token): ?User;
}
