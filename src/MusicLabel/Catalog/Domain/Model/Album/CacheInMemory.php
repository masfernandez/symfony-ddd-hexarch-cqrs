<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

interface CacheInMemory
{
    public function get($key);

    public function set($key, $value, $timeout = null);

    public function del(...$keys);
}
