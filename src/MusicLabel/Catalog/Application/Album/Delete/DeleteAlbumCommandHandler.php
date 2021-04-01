<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

final class DeleteAlbumCommandHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $albumDeleter)
    {
    }

    public function __invoke(DeleteAlbumCommand $command)
    {
        $this->albumDeleter->execute($command);
    }
}
