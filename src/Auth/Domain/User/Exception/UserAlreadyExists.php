<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\Exception;

use Masfernandez\MusicLabel\Shared\Domain\DomainException;

final class UserAlreadyExists extends DomainException
{
}
