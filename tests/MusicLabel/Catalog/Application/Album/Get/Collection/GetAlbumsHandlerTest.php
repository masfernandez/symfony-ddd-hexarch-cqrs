<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumsResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\GetAlbumsHandler;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetAlbumsHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteATransactionalApplicationService(): void
    {
        $query = GetAlbumsQueryMother::create();
        $album = AlbumMother::create();
        $resultSet = [$album];
        $expectedResponse = new AlbumsResponse($resultSet, count($resultSet), $query->getPage(), $query->getSize());

        $applicationService = Mockery::mock(ApplicationServiceInterface::class);
        $applicationService->expects()->execute($query)->andReturns($expectedResponse);

        $actualResponse = (new GetAlbumsHandler($applicationService))($query);
        self::assertEquals($actualResponse, $expectedResponse);
    }
}
