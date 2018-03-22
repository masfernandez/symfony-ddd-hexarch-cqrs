<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Service;

use App\Application\UseCase\Artist\Dto\ArtistDto;
use App\Application\UseCase\Artist\Dto\FindOneArtistDto;
use App\Domain\Model\Artist\ArtistId;
use App\Domain\Model\Artist\ArtistRepositoryInterface;

class FindOneArtistService
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
     * @param FindOneArtistDto $dto
     * @return ArtistDto
     */
    public function handle($dto)
    {
        $artist = $this->artistRepository->findOne($dto->getArtistId());
        return new ArtistDto(
            $artist->getId(),
            $artist->getName(),
            $artist->getSpecialisation(),
            $artist->getAlbum()->getId()
        );
    }
}