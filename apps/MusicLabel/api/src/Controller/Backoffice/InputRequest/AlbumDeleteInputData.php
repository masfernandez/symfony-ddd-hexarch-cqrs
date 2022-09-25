<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest;

use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumDeleteInputData extends InputDataAbstract
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters['id'] = $request->attributes->get('_route_params')['id'];

        $constrains = [
            'id' => AlbumId::getConstraints(),
        ];

        $albumConstrains = new Assert\Collection($constrains);
        $violations      = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
        }

        return $violations;
    }
}
