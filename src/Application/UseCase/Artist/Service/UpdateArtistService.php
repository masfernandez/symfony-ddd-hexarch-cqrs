<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Service;

use App\Application\UseCase\Artist\Dto\UpdateArtistDto;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Domain\Model\Artist\ArtistRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UpdateArtistService
 * @package App\Application\UseCase\Artist
 */
class UpdateArtistService
{
    /**
     * @var ArtistRepositoryInterface
     */
    private $artistRepository;

    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;


    public function __construct(ArtistRepositoryInterface $artistRepository,
                                AlbumRepositoryInterface $albumRepository)
    {
        $this->artistRepository = $artistRepository;
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param null $dto
     */
    public function handle($dto = null)
    {
        $artist = $this->artistRepository->findOne($dto->getId());
        if (!$artist) {
            throw new NotFoundHttpException();
        }
        //$album = $this->albumRepository->findOne($dto->getAlbumId());
        $artist->update($dto->getName(), $dto->getSpecialisation());
        $this->artistRepository->save($artist);
    }
}
