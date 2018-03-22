<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album\Query\GetAll;

use App\Application\UseCase\Album\Query\GetAll\GetAllHandler;
use App\Application\UseCase\Album\Query\GetAll\GetAllQuery;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetAllHandlerTest extends TestCase
{
    /**
     *
     */
    public function testHandle()
    {
        $albumRepositoryMock = $this->createMock(AlbumRepositoryInterface::class);
        $albumRepositoryMock->expects($this->any())->method('findAll')->willReturn([]);

        try {
            $command = new GetAllQuery();
            $handler = new GetAllHandler($albumRepositoryMock);
            $albums = $handler->handle($command);
            if (!is_array($albums)) {
                throw new \Exception();
            }
        } catch (\Exception $exception) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}