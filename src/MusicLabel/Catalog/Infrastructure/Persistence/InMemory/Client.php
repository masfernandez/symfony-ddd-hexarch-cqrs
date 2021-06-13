<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Infrastructure\Persistence\InMemory;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\CacheInMemory;

final class Client implements CacheInMemory
{
    private array $data = [];

    public function get($key): string|bool
    {
        return ($this->data[$key] ?? false);
    }

    public function set($key, $value, $timeout = null): bool
    {
        $this->data[$key] = $value;
        return true;
    }

    public function del(...$keys): int
    {
        $i = 0;
        foreach ($keys as $key) {
            unset($this->data[$key]);
            $i++;
        }
        return $i;
    }
}
