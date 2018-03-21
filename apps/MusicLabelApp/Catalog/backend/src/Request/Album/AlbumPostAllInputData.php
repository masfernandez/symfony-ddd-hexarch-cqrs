<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Request\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Request\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPostAllInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $publishing_date;

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

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];

        $albumConstrains = new Assert\Collection(
            [
                'id' => AlbumId::getConstraints(),
                'title' => AlbumTitle::getConstraints(),
                'publishing_date' => AlbumPublishingDate::getConstraints(),
            ]
        );
        $violations = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id = $parameters['id'];
            $this->title = $parameters['title'];
            $this->publishing_date = $parameters['publishing_date'];
        }

        return $violations;
    }
}
