<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\Redis;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\InMemoryRepository;
use Redis;

final class Client implements InMemoryRepository
{
    public function __construct(private Redis $redis)
    {
    }

    /**
     * @return string|bool
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value, $timeout = null): bool
    {
        return $this->redis->set($key, $value, $timeout);
    }

    public function del(...$otherKeys): int
    {
        return $this->redis->del($otherKeys);
    }
}