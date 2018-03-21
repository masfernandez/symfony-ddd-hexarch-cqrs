<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Application\Album\Post\PostAlbumCommandHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class PostAlbumCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteATransactionalApplicationService(): void
    {
        $command = PostAlbumCommandMother::create();
        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($command);

        (new PostAlbumCommandHandler($applicationService))($command);
    }
}
