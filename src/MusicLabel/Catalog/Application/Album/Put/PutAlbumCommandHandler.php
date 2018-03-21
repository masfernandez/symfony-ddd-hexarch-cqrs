<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class PutAlbumCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ApplicationServiceInterface $albumUpdater)
    {
    }

    public function __invoke(PutAlbumCommand $command)
    {
        $this->albumUpdater->execute($command);
    }
}
