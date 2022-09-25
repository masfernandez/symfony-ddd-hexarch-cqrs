<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\JsonWebToken;

use DateTimeZone;
use Exception;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration as LcobucciConfiguration;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebToken;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebTokenValidator;

class Validator implements JsonWebTokenValidator
{
    public function __construct(
        private readonly LcobucciConfiguration $lcobucciConfiguration,
        private readonly Configuration $configuration,
    ) {
    }

    public function validate(JsonWebToken $jwToken): void
    {
        $configuration = $this->lcobucciConfiguration;

        $configuration->setValidationConstraints(
            new IdentifiedBy($this->configuration->identifiedBy()),
            new IssuedBy($this->configuration->issuedBy()),
            new PermittedFor($this->configuration->permittedFor()),
            new StrictValidAt(new SystemClock(new DateTimeZone('UTC')))
        );

        $constraints = $configuration->validationConstraints();
        $token       = $configuration->parser()->parse($jwToken->getValue()->value());
        try {
            $configuration->validator()->assert($token, ...$constraints);
        } catch (Exception|RequiredConstraintsViolated) {
            // @todo
        }
    }
}
