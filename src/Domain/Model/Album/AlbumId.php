<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Album;

use Ramsey\Uuid\Uuid;

/**
 * Class AlbumId
 * @package App\Domain\Model\Album
 */
class AlbumId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    /**
     * @param AlbumId $albumId
     * @return bool
     */
    public function equals(AlbumId $albumId)
    {
        return $this->id() === $albumId->id();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
