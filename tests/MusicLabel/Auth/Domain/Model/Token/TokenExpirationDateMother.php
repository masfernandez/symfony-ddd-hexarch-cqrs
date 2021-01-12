<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token;

use DateTime;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenExpirationDate;

class TokenExpirationDateMother
{

    public static function create(?DateTime $date = null): TokenExpirationDate
    {
        return new TokenExpirationDate(
            $date ?? date(TokenExpirationDate::$format, strtotime(TokenExpirationDate::$validity_period))
        );
    }
}