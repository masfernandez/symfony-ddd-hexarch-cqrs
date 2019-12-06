<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Application\UseCase\Album;

use App\Application\TransactionManager;
use App\Application\UseCase\Album\Command\Add\AddCommand;
use App\Application\UseCase\Album\Command\Add\AddHandler;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class AddHandlerTest
 * @package App\Tests\Application\UseCase\Album
 */
class AddHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function handle()
    {
        $albumName = 'Album test phpunit';
        $date = new \DateTime();

        $transactionManager = $this->createMock(TransactionManager::class);
        $transactionManager->expects($this->any())->method('begin');
        $transactionManager->expects($this->any())->method('commit');
        $transactionManager->expects($this->any())->method('rollback');

        $albumRepository = $this->createMock(AlbumRepositoryInterface::class);
        $albumRepository->expects($this->any())->method('save');
        $albumRepository->expects($this->any())->method('nextIdentity')->willReturn(new AlbumId());

        $command = new AddCommand($albumName, $date);
        $handler = new AddHandler($albumRepository, $transactionManager);
        try {
            $handler->handle($command);
        } catch (\Exception $ex) {
            $this->assertTrue(false);
        }
        $this->assertTrue(true);
    }
}