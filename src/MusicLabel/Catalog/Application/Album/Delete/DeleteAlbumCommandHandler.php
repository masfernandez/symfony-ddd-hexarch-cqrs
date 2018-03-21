<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class DeleteAlbumCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ApplicationServiceInterface $albumDeleter)
    {
    }

    public function __invoke(DeleteAlbumCommand $command)
    {
        $this->albumDeleter->execute($command);
    }
}
