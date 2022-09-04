<?php

/** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection DuplicatedCode */

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\Album\InputRequest;

use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
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
        return $this->release_date;
    }

    protected function extractAndValidateData(Request $request): ConstraintViolationListInterface
    {
        $parameters       = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        $parameters['id'] = $request->attributes->get('_route_params')['id'];

        $constrains = [
            'id' => AlbumId::getConstraints()
        ];
        if (isset($parameters['title'])) {
            $constrains['title'] = [
                new Constraints\NotBlank(),
                new Constraints\Length(['max' => 60])
            ];
        }
        if (isset($parameters['release_date'])) {
            $constrains['release_date'] = [
                new Constraints\NotBlank(),
                new Constraints\DateTime()
            ];
        }

        $albumConstrains = new Constraints\Collection($constrains);
        $violations      = Validation::createValidator()->validate($parameters, $albumConstrains);

        if ($violations->count() === 0) {
            $this->id              = $parameters['id'];
            $this->title           = $parameters['title'] ?: null;
            $this->release_date = $parameters['release_date'] ?: null;
        }

        return $violations;
    }
}
