<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Artist;

use Ramsey\Uuid\Uuid;

/**
 * Class ArtistId
 * @package App\Domain\Model\Album
 */
class ArtistId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ArtistId constructor.
     * @param null $id
     * @throws \Exception
     */
    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    /**
     * @param ArtistId $artistId
     * @return bool
     */
    public function equals(ArtistId $artistId)
    {
        return $this->id() === $artistId->id();
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
