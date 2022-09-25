<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection DuplicatedCode
 */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPostCollectionInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $releaseDate;
    private float $price;
    private string $token;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters          = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['token'] = str_replace('Bearer ', '', $request->headers->get('Authorization', ''));

        $albumConstrains = new Constraints\Collection(
            [
                'id'           => AlbumId::getConstraints(),
                'title'        => AlbumTitle::getConstraints(),
                'release_date' => AlbumReleasedAtDate::getConstraints(),
                'price'        => AlbumPrice::getConstraints(),
                'token'        => TokenValue::getConstraints(),
            ]
        );
        $violations      = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id          = $parameters['id'];
            $this->title       = $parameters['title'];
            $this->releaseDate = $parameters['release_date'];
            $this->price       = (float)$parameters['price'];
            $this->token       = $parameters['token'];
        }

        return $violations;
    }
}
