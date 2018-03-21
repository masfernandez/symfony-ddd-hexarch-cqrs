<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Delete;

use App\Application\TransactionManager;
use App\Domain\Bus\CommandHandlerInterface;
use App\Domain\Model\Album\AlbumRepositoryInterface;

/**
 * Class DeleteHandler
 * @package App\Application\UseCase\Album\Command\Add
 */
class DeleteHandler implements CommandHandlerInterface
{
    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * AddHandler constructor.
     * @param AlbumRepositoryInterface $albumRepository
     * @param TransactionManager $transactionManager
     */
    public function __construct(AlbumRepositoryInterface $albumRepository, TransactionManager $transactionManager)
    {
        $this->albumRepository = $albumRepository;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param DeleteCommand $command
     * @throws \Exception
     */
    public function handle(DeleteCommand $command)
    {
        $this->transactionManager->begin();
        try {
            $this->albumRepository->remove($command->id);
            $this->transactionManager->commit();
        } catch (\Exception $ex) {
            $this->transactionManager->rollback();
            throw $ex;
        }
    }
}