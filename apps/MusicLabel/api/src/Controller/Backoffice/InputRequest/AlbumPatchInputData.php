<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPatchInputData extends InputDataAbstract
{
    private string $id;
    private ?string $title;
    private ?string $release_date;
    private ?float $price;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getReleaseDate(): ?string
    {
        return $this->release_date;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters       = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id'] = $request->attributes->get('_route_params')['id'];

        $constrains = [
            'id' => AlbumId::getConstraints(),
        ];

        if (isset($parameters['title'])) {
            $constrains['title'] = AlbumTitle::getConstraints();
        }

        if (isset($parameters['release_date'])) {
            $constrains['release_date'] = AlbumReleasedAtDate::getConstraints();
        }

        if (isset($parameters['price'])) {
            $constrains['price'] = AlbumPrice::getConstraints();
        }

        $albumConstrains = new Constraints\Collection($constrains);
        $violations      = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id           = $parameters['id'];
            $this->title        = $parameters['title'] ?: null;
            $this->release_date = $parameters['release_date'] ?: null;
            $this->price        = (float)$parameters['release_date'] ?: null;
        }

        return $violations;
    }
}
