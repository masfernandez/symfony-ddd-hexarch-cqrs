<?php

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Catalog\Application\Album\Delete\DeleteAlbumCommandHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeleteAlbumCommandHandlerTest extends KernelTestCase
{
    /**
     * @test
     */
    public function itShouldExecuteAnApplicationService(): void
    {
        $command = DeleteAlbumCommandMother::create();
        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($command);

        $handler = new DeleteAlbumCommandHandler($applicationService);
        $handler($command);
    }
}
