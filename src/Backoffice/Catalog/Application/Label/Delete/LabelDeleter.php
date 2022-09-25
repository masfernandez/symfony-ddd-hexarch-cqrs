<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Label\Delete;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\Exceptions\LabelNotFound;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\LabelRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class LabelDeleter implements ApplicationService
{
    public function __construct(
        private readonly LabelRepository $labelRepository,
    ) {
    }

    /**
     * @throws LabelNotFound
     */
    public function execute(Request|DeleteLabelCommand $request): ?Response
    {
        $label = $this->labelRepository->search(id: $request->getId()) ??
            throw new LabelNotFound();

        $this->labelRepository->remove(label: $label);

        return null;
    }
}
