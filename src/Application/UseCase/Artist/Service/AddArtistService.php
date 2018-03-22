<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Service;

use App\Application\TransactionManager;
use App\Application\UseCase\Artist\Dto\AddArtistDto;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Domain\Model\Artist\Artist;
use App\Domain\Model\Artist\ArtistRepositoryInterface;

/**
 * Class AddArtistToAlbum
 * @package App\Application\UseCase\Artist\Service
 */
class AddArtistService
{
    /**
     * @var ArtistRepositoryInterface
     */
    private $artistRepository;

    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * AddArtistToAlbum constructor.
     * @param ArtistRepositoryInterface $artistRepository
     * @param AlbumRepositoryInterface $albumRepository
     * @param TransactionManager $transactionManager
     */
    public function __construct(ArtistRepositoryInterface $artistRepository,
                                AlbumRepositoryInterface $albumRepository,
                                TransactionManager $transactionManager)
    {
        $this->artistRepository = $artistRepository;
        $this->albumRepository = $albumRepository;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param AddArtistDto $dto
     * @throws \Exception
     */
    public function handle($dto)
    {
        $this->transactionManager->begin();
        try {
            $album = $this->albumRepository->findOne(new AlbumId($dto->getAlbumId()));
            $artist = new Artist(
                $this->artistRepository->nextIdentity(),
                $dto->getName(),
                $dto->getSpecialisation(),
                new \DateTime(),
                $album
            );
            $this->artistRepository->save($artist);
            $this->transactionManager->commit();
        } catch (\Exception $ex) {
            $this->transactionManager->rollback();
            throw $ex;
        }
    }
}