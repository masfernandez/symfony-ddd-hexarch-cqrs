<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token;

use DateTimeInterface;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;

class TokenExpirationDateMother
{
    public static function create(?DateTimeInterface $date = null): TokenExpirationDate
    {
        return new TokenExpirationDate(
            value: $date ??
                   date(TokenExpirationDate::FORMAT, strtotime(TokenExpirationDate::VALIDITY_PERIOD))
        );
    }
}
