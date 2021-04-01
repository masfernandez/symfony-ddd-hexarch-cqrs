<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

final class PutAlbumCommandHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $albumUpdater)
    {
    }

    public function __invoke(PutAlbumCommand $command)
    {
        $this->albumUpdater->execute($command);
    }
}
