<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\PutAlbumCommandHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class PutAlbumCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteATransactionalApplicationService(): void
    {
        $command = PutAlbumCommandMother::create();
        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($command);

        (new PutAlbumCommandHandler($applicationService))($command);
    }
}
