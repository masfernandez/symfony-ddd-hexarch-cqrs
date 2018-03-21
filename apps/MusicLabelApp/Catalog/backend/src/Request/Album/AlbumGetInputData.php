<?php

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Request\Album;

use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Request\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumGetInputData extends InputDataAbstract
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $albumId = $request->attributes->get('_route_params')['id'];

        $albumConstrains = AlbumId::getConstraints();
        $violations = Validation::createValidator()->validate($albumId, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $albumId;
        }

        return $violations;
    }
}
