<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection DuplicatedCode
 */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Backoffice\InputRequest;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\JsonWebTokenValue;
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

final class AlbumPutInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $releasedAtDate;
    private string $jsonWebToken;
    private float $price;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReleasedAtDate(): string
    {
        return $this->releasedAtDate;
    }

    public function getJsonWebToken(): string
    {
        return $this->jsonWebToken;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters          = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id']    = $request->attributes->get('_route_params')['id'];
        $token               = str_replace('Bearer ', '', $request->headers->get('Authorization') ?? '');
        $token               .= $token !== '' ? '.' : '';
        $token               .= $request->cookies->get('signature', '');
        $parameters['token'] = $token;

        $albumConstrains = new Constraints\Collection(
            [
                'id'           => AlbumId::getConstraints(),
                'title'        => AlbumTitle::getConstraints(),
                'release_date' => AlbumReleasedAtDate::getConstraints(),
                'token'        => JsonWebTokenValue::getConstraints(),
                'price'        => AlbumPrice::getConstraints(),
            ]
        );

        $violations = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id             = $parameters['id'];
            $this->title          = $parameters['title'];
            $this->releasedAtDate = $parameters['release_date'];
            $this->price          = (float)$parameters['price'];
            $this->jsonWebToken   = $parameters['token'];
        }

        return $violations;
    }
}
