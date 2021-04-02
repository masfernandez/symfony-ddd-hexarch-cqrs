<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Shared\Domain\Model\Token\TokenId;
use Masfernandez\Shared\Domain\Model\Aggregate;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class Token extends Aggregate implements Stringable
{
    // phpcs:disable
    public function __construct(
        private User $user,
        private TokenValue $value,
        private TokenExpirationDate $expiration_date,
        private TokenId $id
    )
    {
    }
    // phpcs:enable

    public static function create(User $user): self
    {
        // @todo handle exception
        $value = substr(bin2hex(random_bytes(TokenValue::BYTES_LENGTH)), 0, TokenValue::HEX_LENGTH);
        $expiration_date = date(TokenExpirationDate::FORMAT, strtotime(TokenExpirationDate::VALIDITY_PERIOD));
        return new Token($user, new TokenValue($value), new TokenExpirationDate($expiration_date), new TokenId(null));
    }

    public function __toString(): string
    {
        return $this::class . ':' . $this->value->value();
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
