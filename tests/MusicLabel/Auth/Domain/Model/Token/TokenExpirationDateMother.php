<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token;

use DateTime;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenExpirationDate;

class TokenExpirationDateMother
{

    /**
     * @param \DateTime|\DateTimeImmutable|null $date
     */
    public static function create(?\DateTimeInterface $date = null): TokenExpirationDate
    {
        return new TokenExpirationDate(
            $date ??
            date(TokenExpirationDate::FORMAT, strtotime(TokenExpirationDate::VALIDITY_PERIOD))
        );
    }
}