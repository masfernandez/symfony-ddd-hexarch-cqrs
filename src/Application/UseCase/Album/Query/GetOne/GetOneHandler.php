<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Query\GetOne;

use App\Application\UseCase\Album\Dto\AlbumDto;
use App\Domain\Bus\QueryHandlerInterface;
use App\Domain\Model\Album\AlbumRepositoryInterface;

/**
 * Class GetOneHandler
 * @package App\Application\UseCase\Album\Query\GetOne
 */
class GetOneHandler implements QueryHandlerInterface
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
     * @param GetOneQuery $query
     * @return AlbumDto
     */
    public function handle(GetOneQuery $query)
    {
        $album = $this->albumRepository->findOne($query->id);
        return new AlbumDto(
            $album->getId(),
            $album->getTitle(),
            $album->getPublishingDate(),
            $album->getArtists()
        );
    }
}