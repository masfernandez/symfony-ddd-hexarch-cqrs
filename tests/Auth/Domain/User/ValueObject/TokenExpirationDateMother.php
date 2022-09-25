<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject;

use DateTimeInterface;
use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;
use Masfernandez\ValueObject\ValueObjectException;

class TokenExpirationDateMother
{
    /**
     * @throws ValueObjectException
     */
    public static function create(
        ?DateTimeInterface $date = null,
    ): TokenExpirationDate {
        if ($date === null) {
            $value = date(DATE_W3C, strtotime(Token::VALIDITY_PERIOD));
        } else {
            $value = $date->format(DATE_W3C);
        }
        return new TokenExpirationDate(
            value: $value,
        );
    }
}
