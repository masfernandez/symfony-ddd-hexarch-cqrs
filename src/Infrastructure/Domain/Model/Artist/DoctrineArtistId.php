<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Domain\Model\Artist;

use App\Infrastructure\Domain\Model\DoctrineEntityId;

/**
 * Class DoctrineArtistId
 * @package App\Infrastructure\Domain\Model\Artist
 */
class DoctrineArtistId extends DoctrineEntityId
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'ArtistId';
    }

    /**
     * @inheritdoc
     */
    protected function getNamespace()
    {
        return 'App\Domain\Model\Artist';
    }
}
