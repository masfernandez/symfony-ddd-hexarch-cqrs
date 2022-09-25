<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\Create;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelAlreadyExists;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Label;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class LabelCreator implements ApplicationService
{
    public function __construct(
        private readonly LabelRepository $labelRepository,
    ) {
    }

    /**
     * @throws LabelAlreadyExists
     */
    public function execute(Request|CreateLabelCommand $request): ?Response
    {
        $this->labelRepository->add(
            Label::create(
                id:   $request->getId(),
                name: $request->getName(),
            )
        );

        return null;
    }
}
