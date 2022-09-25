<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\TokenExpired;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\AggregateRoot;
use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;
use ReflectionClass;
use Stringable;

class User extends AggregateRoot implements Stringable
{
    private Collection $tokens;

    private function __construct(
        private readonly UserId $id,
        private readonly UserEmail $email,
        private readonly UserPassword $password,
    ) {
        $this->tokens = new ArrayCollection();
    }

    public static function create(
        UserId $id,
        UserEmail $email,
        UserPassword $password,
    ): User {
        return new self(
            id:       $id,
            email:    $email,
            password: $password,
        );
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getTokens(): ArrayCollection
    {
        return $this->tokens;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    /**
     * @throws WrongPassword
     */
    public function comparePassword(UserPassword $password): void
    {
        if (!password_verify($password->value(), $this->password->value())) {
            throw new WrongPassword();
        }
    }

    /**
     * @throws WrongPassword
     */
    public function createNewToken(UserPassword $password): Token
    {
        $this->comparePassword($password);

        $token = Token::create($this);
        $this->tokens->add($token);
        return $token;
    }

    /**
     * @throws TokenExpired
     */
    public function authenticate(): void
    {
        $token = $this->tokens->first();
        if ($token->isExpired()) {
            throw new TokenExpired();
        }
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->id->value()}";
    }
}
