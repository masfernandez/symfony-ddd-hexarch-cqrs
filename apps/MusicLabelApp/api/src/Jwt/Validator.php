<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Jwt;

use DateTimeZone;
use Exception;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Masfernandez\MusicLabel\Auth\Domain\User\JwTokenValidator;

class Validator implements JwTokenValidator
{
    public function __construct(private Configuration $configuration, private TokenConfig $tokenConfig)
    {
    }

    public function validate($value): void
    {
        $configuration = $this->configuration;

        $configuration->setValidationConstraints(
            new IdentifiedBy($this->tokenConfig->identifiedBy()),
            new IssuedBy($this->tokenConfig->issuedBy()),
            new PermittedFor($this->tokenConfig->permittedFor()),
            new StrictValidAt(new SystemClock(new DateTimeZone('UTC')))
        );

        $constraints = $configuration->validationConstraints();
        $token       = $configuration->parser()->parse($value);
        try {
            $configuration->validator()->assert($token, ...$constraints);
        } catch (Exception | RequiredConstraintsViolated) {
            // @todo
        }
    }
}
