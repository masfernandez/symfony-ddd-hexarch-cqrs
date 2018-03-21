<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Query\GetAll;

use App\Application\UseCase\Album\Dto\AlbumDto;
use App\Domain\Bus\QueryHandlerInterface;
use App\Domain\Model\Album\Album;
use App\Domain\Model\Album\AlbumRepositoryInterface;

/**
 * Class GetAllHandler
 * @package App\Application\UseCase\Album\Query\GetAll
 */
class GetAllHandler implements QueryHandlerInterface
{
    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;

    /**
     * AddAlbumService constructor.
     * @param AlbumRepositoryInterface $albumRepository
     */
    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param GetAllQuery $query
     * @return array
     */
    public function handle(GetAllQuery $query)
    {
        $albums = $this->albumRepository->findAll();

        return array_map(function (Album $album) {
            return new AlbumDto(
                $album->getId(),
                $album->getTitle(),
                $album->getPublishingDate(),
                $album->getArtists());
        }, $albums);
    }
}