<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Application\Service;

use Exception;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class TransactionalApplicationServiceDecorator implements ApplicationServiceInterface
{
    public function __construct(private ApplicationServiceInterface $service, private TransactionalSession $session)
    {
    }

    /** @throws TransactionalApplicationService */
    public function execute(Request $request): mixed
    {
        $operation = function () use ($request) {
            return $this->service->execute($request);
        };

        try {
            $result = $this->session->executeTransactionalOperation($operation);
        } catch (Exception $ex) {
            throw new TransactionalApplicationService($ex->getMessage(), (int)$ex->getCode(), $ex);
        }

        return $result;
    }
}
