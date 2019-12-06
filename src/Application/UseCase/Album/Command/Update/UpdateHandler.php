<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Update;

use App\Application\TransactionManager;
use App\Domain\Bus\CommandHandlerInterface;
use App\Domain\Model\Album\AlbumRepositoryInterface;

/**
 * Class UpdateHandler
 * @package App\Application\UseCase\Album\Command\Delete
 */
class UpdateHandler implements CommandHandlerInterface
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
     * @param UpdateCommand $command
     * @throws \Exception
     */
    public function handle(UpdateCommand $command)
    {
        $this->transactionManager->begin();
        try {
            $album = $this->albumRepository->findOne($command->id);
            $album->update(
                $command->title,
                $command->publishing_date
            );
            $this->albumRepository->save($album);
            $this->transactionManager->commit();
        } catch (\Exception $ex) {
            $this->transactionManager->rollback();
            throw $ex;
        }
    }
}