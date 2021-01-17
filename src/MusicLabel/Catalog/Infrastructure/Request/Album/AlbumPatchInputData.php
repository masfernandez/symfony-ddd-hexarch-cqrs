<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Request\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabel\Shared\Infrastructure\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPatchInputData extends InputDataAbstract
{
    private string $id;
    private ?string $title;
    private ?string $publishing_date;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getPublishingDate(): ?string
    {
        return $this->publishing_date;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id'] = $request->attributes->get('_route_params')['id'];

        $constrains = [
            'id' => AlbumId::getConstraints()
        ];
        if (isset($parameters['title'])) {
            $constrains['title'] = AlbumTitle::getConstraints();
        }
        if (isset($parameters['publishing_date'])) {
            $constrains['publishing_date'] = AlbumPublishingDate::getConstraints();
        }

        $albumConstrains = new Assert\Collection($constrains);
        $violations = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
            $this->title = $parameters['title'] ?: null;
            $this->publishing_date = $parameters['publishing_date'] ?: null;
        }

        return $violations;
    }
}
