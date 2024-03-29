<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Auth\InputRequest;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class TokenPostInputData extends InputDataAbstract
{
    private string $email;
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters      = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $tokenConstrains = new Assert\Collection(
            [
                'email'    => UserEmail::getConstraints(),
                'password' => UserPassword::getConstraints(),
            ]
        );
        $violations      = Validation::createValidator()->validate($parameters, $tokenConstrains);

        if ($violations->count() === 0) {
            $this->email    = $parameters['email'];
            $this->password = $parameters['password'];
        }

        return $violations;
    }
}
