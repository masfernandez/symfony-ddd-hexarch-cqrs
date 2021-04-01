<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Application\Service;

use Masfernandez\Shared\Domain\Bus\Request\Request;

interface ApplicationServiceInterface
{
    public function execute(Request $request);
}
