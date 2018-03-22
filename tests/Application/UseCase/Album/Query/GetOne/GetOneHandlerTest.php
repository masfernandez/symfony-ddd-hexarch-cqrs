<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album\Query\GetOne;

use App\Application\UseCase\Album\Query\GetOne\GetOneHandler;
use App\Application\UseCase\Album\Query\GetOne\GetOneQuery;
use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class GetOneHandlerTest
 * @package App\Tests\Application\UseCase\Album\Query\GetOne
 */
class GetOneHandlerTest extends TestCase
{
    public function testHandle()
    {
        $albumId = new AlbumId(Uuid::uuid4()->toString());
        $album = new Album($albumId,'title',new \DateTime());
        $albumRepositoryMock = $this->createMock(AlbumRepositoryInterface::class);
        $albumRepositoryMock->expects($this->any())->method('findOne')->willReturn($album);

        try {
            $command = new GetOneQuery(1);
            $handler = new GetOneHandler($albumRepositoryMock);
            $this->assertTrue($album->getId()->id() === $handler->handle($command)->getId());
        } catch (\Exception $exception) {
            $this->fail();
        }
    }
}