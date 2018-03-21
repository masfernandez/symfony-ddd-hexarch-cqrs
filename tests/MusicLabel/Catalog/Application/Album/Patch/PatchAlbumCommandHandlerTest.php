<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Application\Album\Patch\PatchAlbumCommandHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class PatchAlbumCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteATransactionalApplicationService(): void
    {
        $command = PatchAlbumCommandMother::create();
        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($command);

        (new PatchAlbumCommandHandler($applicationService))($command);
    }
}
