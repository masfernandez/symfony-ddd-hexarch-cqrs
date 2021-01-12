<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Shared\Domain\Model\Token\TokenId;
use Masfernandez\Shared\Domain\Model\Aggregate;
use Stringable;

class Token extends Aggregate implements Stringable
{
    public function __construct(
        private User $user,
        private TokenValue $value,
        private TokenExpirationDate $expiration_date,
        private TokenId $id)
    {
    }

    public static function create(User $user): self
    {
        $value = str_split(bin2hex(random_bytes(TokenValue::$bytes_length)), TokenValue::$hex_length);
        $expiration_date = date(TokenExpirationDate::$format, strtotime(TokenExpirationDate::$validity_period));
        return new Token($user, new TokenValue($value), new TokenExpirationDate($expiration_date), new TokenId(null));
    }

    public function __toString(): string
    {
        return get_class($this) . ':' . $this->value->value();
    }

    public function value(): string
    {
        return $this->value->value();
    }

    public function getUser(): User
    {
        return $this->user;
    }
}