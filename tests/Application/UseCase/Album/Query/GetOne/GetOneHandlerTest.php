<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album\Query\GetOne;

use App\Application\TransactionManager;
use App\Application\UseCase\Album\Command\Update\UpdateCommand;
use App\Application\UseCase\Album\Command\Update\UpdateHandler;
use App\Application\UseCase\Album\Query\GetOne\GetOneHandler;
use App\Application\UseCase\Album\Query\GetOne\GetOneQuery;
use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Infrastructure\Persistence\InMemory\Repository\AlbumRepository;
use PHPUnit\Framework\TestCase;

class GetOneHandlerTest extends TestCase
{
    public function testHandle()
    {
        $albumRepositoryMock = $this->createMock(AlbumRepositoryInterface::class);
        //@todo findOne will return an album
        $albumRepositoryMock->expects($this->any())->method('findOne')->willReturn(new Album());

        try {
            $command = new GetOneQuery(1);
            $handler = new GetOneHandler($albumRepositoryMock);
            $album = $handler->handle($command);
            //@todo check album
        } catch (\Exception $exception) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}