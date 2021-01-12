<?php

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album;

use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest\InputDataAbstract;
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
            'id' => AlbumId::getConstraints()
        ];
        $albumConstrains = new Assert\Collection($constrains);
        $violations = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
        }

        return $violations;
    }
}
