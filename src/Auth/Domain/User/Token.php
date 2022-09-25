<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use DateTimeImmutable;
use Exception;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\SourceOfRandomnessNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Shared\Domain\AggregateRoot;
use ReflectionClass;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class Token extends AggregateRoot implements Stringable
{
    private const       BYTES_LENGTH    = 32;
    final public const  HEX_LENGTH      = 64;
    final public const  VALIDITY_PERIOD = '+5 days';

    private function __construct(
        private readonly User $user,
        private readonly TokenValue $value,
        private readonly TokenExpirationDate $expirationDate,
    ) {
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public static function create(
        User $user,
        ?string $value = null,
    ): self {
        $value           = $value ?? self::generateRandomTokenValue();
        $expiration_date = date(DATE_W3C, strtotime(self::VALIDITY_PERIOD));

        return new self(
            user:           $user,
            value:          new TokenValue($value),
            expirationDate: new TokenExpirationDate($expiration_date),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private static function generateRandomTokenValue(): string
    {
        try {
            $randomBytes = random_bytes(length: self::BYTES_LENGTH);
        } catch (Exception $e) {
            throw new SourceOfRandomnessNotFound($e->getMessage(), (int)$e->getCode(), $e);
        }
        $hexBytes = bin2hex(string: $randomBytes);
        return substr(
            string: $hexBytes,
            offset: 0,
            length: self::HEX_LENGTH,
        );
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function value(): string
    {
        return $this->value->value();
    }

    public function isExpired(): bool
    {
        return $this->expirationDate->value() < (new DateTimeImmutable());
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->value()}";
    }
}
