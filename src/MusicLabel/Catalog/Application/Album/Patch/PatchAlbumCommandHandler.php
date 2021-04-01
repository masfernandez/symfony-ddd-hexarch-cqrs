<?php

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

final class PatchAlbumCommandHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $albumPatcher)
    {
    }

    public function __invoke(PatchAlbumCommand $command): void
    {
        $this->albumPatcher->execute($command);
    }
}
