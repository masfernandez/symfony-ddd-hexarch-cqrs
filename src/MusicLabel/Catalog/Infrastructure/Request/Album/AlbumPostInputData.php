<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenValue;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPostInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $publishing_date;
    private string $token;

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

    public function getToken(): string
    {
        return $this->token;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id'] = $request->attributes->get('_route_params')['id'];
        $parameters['token'] = str_replace('Bearer ', '', $request->headers->get('Authorization',''));

        $inputConstraints = new Assert\Collection(
            [
                'id' => AlbumId::getConstraints(),
                'title' => AlbumTitle::getConstraints(),
                'publishing_date' => AlbumPublishingDate::getConstraints(),
                'token' => TokenValue::getConstraints(),
            ]
        );
        $violations = Validation::createValidator()->validate($parameters, $inputConstraints);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
            $this->title = $parameters['title'];
            $this->publishing_date = $parameters['publishing_date'];
            $this->token = $parameters['token'];
        }

        return $violations;
    }
}
