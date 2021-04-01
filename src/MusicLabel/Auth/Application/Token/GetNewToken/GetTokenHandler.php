<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Query\QueryHandler;

final class GetTokenHandler implements QueryHandler
{
    public function __construct(private ApplicationServiceInterface $newTokenCreator)
    {
    }

    public function __invoke(GetTokenQuery $query): TokenResponse
    {
        return $this->newTokenCreator->execute($query);
    }
}
