<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Repository\Cache\Redis;

use Masfernandez\MusicLabel\Catalog\Domain\Album\CacheInMemory;
use Redis;

final class Client implements CacheInMemory
{
    public function __construct(private Redis $redis)
    {
    }

    public function get($key): string|bool
    {
        return $this->redis->get($key);
    }

    public function set($key, $value, $timeout = null): bool
    {
        return $this->redis->set($key, $value, $timeout);
    }

    public function del(...$keys): int
    {
        return $this->redis->del($keys);
    }
}