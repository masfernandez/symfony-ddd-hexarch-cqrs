<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album;

use App\Application\TransactionManager;
use App\Application\UseCase\Album\Command\Update\UpdateCommand;
use App\Application\UseCase\Album\Command\Update\UpdateHandler;
use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateHandlerTest
 * @package App\Tests\Application\UseCase\Album
 */
class UpdateHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function testHandle()
    {
        $albumId = 1;
        $albumName = 'Album test phpunit';
        $date = new \DateTime();

        $albumMock = $this->createMock(Album::class);
        $albumMock->expects($this->any())->method('getId')->willReturn($albumId);


        $albumRepositoryMock = $this->createMock(AlbumRepositoryInterface::class);
        $albumRepositoryMock->expects($this->any())->method('findOne')->willReturn($albumMock);
        $albumRepositoryMock->expects($this->any())->method('save');

        $transactionManagerMock = $this->createMock(TransactionManager::class);
        $transactionManagerMock->expects($this->any())->method('begin');
        $transactionManagerMock->expects($this->any())->method('commit');
        $transactionManagerMock->expects($this->any())->method('rollback');

        try {
            $command = new UpdateCommand($albumId, $albumName, $date);
            $handler = new UpdateHandler($albumRepositoryMock, $transactionManagerMock);
            $handler->handle($command);
        } catch (\Exception $exception) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}