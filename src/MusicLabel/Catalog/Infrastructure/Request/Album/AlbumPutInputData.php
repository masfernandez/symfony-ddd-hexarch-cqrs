<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album;

use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenValue;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPutInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $publishing_date;
    private string $jsonWebToken;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPublishingDate(): string
    {
        return $this->publishing_date;
    }

    public function getJsonWebToken(): string
    {
        return $this->jsonWebToken;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id'] = $request->attributes->get('_route_params')['id'];
        $parameters['token'] = str_replace('Bearer ', '', $request->headers->get('Authorization') ?? '');

        $albumConstrains = new Assert\Collection(
            [
                'id' => AlbumId::getConstraints(),
                'title' => AlbumTitle::getConstraints(),
                'publishing_date' => AlbumPublishingDate::getConstraints(),
                'token' => JwTokenValue::getConstraints(),
            ]
        );
        $violations = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
            $this->title = $parameters['title'];
            $this->publishing_date = $parameters['publishing_date'];
            $this->jsonWebToken = $parameters['token'];
        }

        return $violations;
    }
}
