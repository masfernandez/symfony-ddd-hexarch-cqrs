<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumsResponse implements Response
{
    /**
     * @param Album[] $albums
     */
    public function __construct(
        private readonly array $albums,
        private readonly int $total,
        private readonly int $page,
        private readonly int $size
    ) {
    }

    public function toJson(): string
    {
        return json_encode(
            [
                'data'  => $this->getData(),
                'links' => $this->getLinks(),
                'meta'  => $this->getMeta()
            ],
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @return mixed[]
     */
    private function getData(): array
    {
        return $this->albums;
    }

    /**
     * @return array<string, string>
     */
    private function getLinks(): array
    {
        if ($this->total === 0) {
            return [];
        }
        $self  = $this->page;
        $size  = $this->size;
        $last  = ceil($this->total / $this->size);
        $first = 1;
        $prev  = ceil(($self - 1 <= $first) ? $first : $self - 1);
        $next  = ceil(($self + 1 >= $last) ? $last : $self + 1);

        $url = str_replace(['[', ']'], ['%%5B', '%%5D'], '/albums?page[number]=%s&page[size]=%s');

        return [
            'self'  => sprintf($url, $self, $size),
            'first' => sprintf($url, $first, $size),
            'prev'  => sprintf($url, $prev, $size),
            'next'  => sprintf($url, $next, $size),
            'last'  => sprintf($url, $last, $size),
        ];
    }

    /**
     * @return  array<string, float>
     */
    private function getMeta(): array
    {
        return [
            'total_pages' => ceil($this->total / $this->size),
        ];
    }
}
