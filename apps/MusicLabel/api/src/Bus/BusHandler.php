<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Bus;

use Masfernandez\MusicLabel\Shared\Application\Service\Request;

interface BusHandler
{
    public function dispatch(Request $request);
}
