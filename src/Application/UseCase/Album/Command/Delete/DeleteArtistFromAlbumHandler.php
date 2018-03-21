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
use App\Domain\Model\Artist\ArtistRepositoryInterface;

/**
 * Class DeleteArtistFromAlbumHandler
 * @package App\Application\UseCase\Album\Command\Delete
 */
class DeleteArtistFromAlbumHandler implements CommandHandlerInterface
{
    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;

    /**
     * @var ArtistRepositoryInterface
     */
    private $artistRepository;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * DeleteArtistFromAlbumHandler constructor.
     * @param AlbumRepositoryInterface $albumRepository
     * @param ArtistRepositoryInterface $artistRepository
     * @param TransactionManager $transactionManager
     */
    public function __construct(AlbumRepositoryInterface $albumRepository,
                                ArtistRepositoryInterface $artistRepository,
                                TransactionManager $transactionManager)
    {
        $this->albumRepository = $albumRepository;
        $this->artistRepository = $artistRepository;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param DeleteArtistFromAlbumCommand $command
     * @throws \Exception
     */
    public function handle(DeleteArtistFromAlbumCommand $command)
    {
        $this->transactionManager->begin();
        try {
            $album = $this->albumRepository->findOne($command->albumId);
            $artist = $this->artistRepository->findOne($command->artistId);
            $album->deleteArtist($artist);
            $this->albumRepository->save($album);
            $this->transactionManager->commit();
        } catch (\Exception $ex) {
            $this->transactionManager->rollback();
            throw $ex;
        }
    }
}