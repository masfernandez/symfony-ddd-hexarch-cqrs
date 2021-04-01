<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Query\QueryHandler;

final class GetJwtHandler implements QueryHandler
{
    public function __construct(private ApplicationServiceInterface $newJwtCreator)
    {
    }

    public function __invoke(GetJwtQuery $query): JwtResponse
    {
        return $this->newJwtCreator->execute($query);
    }
}
