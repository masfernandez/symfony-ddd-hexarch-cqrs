<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Service;

use App\Application\UseCase\Artist\Dto\ArtistDto;
use App\Domain\Model\Artist\Artist;
use App\Domain\Model\Artist\ArtistRepositoryInterface;

class GetAllArtistService
{
    /**
     * @var ArtistRepositoryInterface
     */
    private $artistRepository;

    /**
     * FindOneArtistService constructor.
     * @param ArtistRepositoryInterface $artistRepository
     */
    public function __construct(ArtistRepositoryInterface $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    /**
     * @return array
     */
    public function handle()
    {
        $artists = $this->artistRepository->findAll();

        $artistsDto = array_map(function ($artist) {
            /** @var Artist $artist */
            return new ArtistDto(
                $artist->getId(),
                $artist->getName(),
                $artist->getSpecialisation(),
                $artist->getAlbums()->toArray()
            );
        }, $artists);

        return $artistsDto;
    }
}
