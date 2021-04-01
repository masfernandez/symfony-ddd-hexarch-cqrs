<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Shared\Domain\Model\User\UserId;
use Masfernandez\Shared\Domain\Model\Aggregate;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class User extends Aggregate implements Stringable
{
    private Collection $tokens;

    public function __construct(private UserId $id, private UserEmail $email, private UserPassword $password)
    {
        $this->tokens = new ArrayCollection();
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return get_class($this) . ':' . $this->id->value();
    }

    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function comparePassword(UserPassword $password): bool
    {
        // @todo compare Salted passwords;
        return $this->password->value() === $password->value();
    }
}
