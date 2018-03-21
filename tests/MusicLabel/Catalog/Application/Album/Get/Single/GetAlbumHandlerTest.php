<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\GetAlbumHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetAlbumHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteATransactionalApplicationService(): void
    {
        $query = GetAlbumQueryMother::create();
        $album = AlbumMother::create(id: $query->id());
        $expectedResponse = new AlbumResponse($album->toArray());
        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($query)->andReturns($expectedResponse);

        $actualResponse = (new GetAlbumHandler($applicationService))($query);
        self::assertEquals($actualResponse, $expectedResponse);
    }
}
