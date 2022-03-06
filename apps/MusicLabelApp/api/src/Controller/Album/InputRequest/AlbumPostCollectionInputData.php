<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album\InputRequest;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest\InputDataAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class AlbumPostCollectionInputData extends InputDataAbstract
{
    private string $id;
    private string $title;
    private string $release_date;
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
        return $this->release_date;
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
                'id'              => AlbumId::getConstraints(),
                'title'           => [
                    new Constraints\NotBlank(),
                    new Constraints\Length(['max' => 60])
                ],
                'release_date' => [
                    new Constraints\NotBlank(),
                    new Constraints\DateTime()
                ],
                'token'           => TokenValue::getConstraints(),
            ]
        );
        $violations      = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id              = $parameters['id'];
            $this->title           = $parameters['title'];
            $this->release_date = $parameters['release_date'];
            $this->token           = $parameters['token'];
        }

        return $violations;
    }
}
