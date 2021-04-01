<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

final class PostAlbumCommandHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $albumCreator)
    {
    }

    public function __invoke(PostAlbumCommand $command)
    {
        $this->albumCreator->execute($command);
    }
}
