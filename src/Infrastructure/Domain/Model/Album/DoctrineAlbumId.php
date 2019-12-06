<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Domain\Model\Album;

use App\Infrastructure\Domain\Model\DoctrineEntityId;

/**
 * Class DoctrineAlbumId
 * @package App\Infrastructure\Domain\Model\Album
 */
class DoctrineAlbumId extends DoctrineEntityId
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'AlbumId';
    }

    /**
     * @inheritdoc
     */
    protected function getNamespace()
    {
        return 'App\Domain\Model\Album';
    }
}
