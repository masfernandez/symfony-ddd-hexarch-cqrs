<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Application\Service;

use Masfernandez\Shared\Domain\Bus\Request\RequestInterface;

final class TransactionalApplicationServiceDecorator implements ApplicationServiceInterface
{
    public function __construct(private ApplicationServiceInterface $service, private TransactionalSession $session)
    {
    }

    public function execute(RequestInterface $request): mixed
    {
        $operation = function () use ($request) {
            return $this->service->execute($request);
        };

        return $this->session->executeTransactionalOperation($operation);
    }
}
