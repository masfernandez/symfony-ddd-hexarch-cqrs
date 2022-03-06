<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Shared\Application\Service;

interface ApplicationService
{
    public function execute(Request $request): ?Response;
}
