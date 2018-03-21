<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album;

use App\Application\TransactionManager;
use App\Application\UseCase\Album\Command\Delete\DeleteCommand;
use App\Application\UseCase\Album\Command\Delete\DeleteHandler;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteHandlerTest
 * @package App\Tests\Application\UseCase\Album
 */
class DeleteHandlerTest extends TestCase
{
    /**
     *
     */
    public function testHandle()
    {
        $albumRepository = $this->createMock(AlbumRepositoryInterface::class);
        $albumRepository->expects($this->any())->method('remove');

        $transactionManager = $this->createMock(TransactionManager::class);
        $transactionManager->expects($this->any())->method('begin');
        $transactionManager->expects($this->any())->method('commit');
        $transactionManager->expects($this->any())->method('rollback');

        $command = new DeleteCommand(1);
        $handler = new DeleteHandler($albumRepository, $transactionManager);
        try {
            $handler->handle($command);
        } catch (\Exception $exception) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}