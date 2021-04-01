<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Application\Service;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Application\Service\TransactionalApplicationServiceDecorator;
use Masfernandez\Shared\Application\Service\TransactionalSession;
use Masfernandez\Shared\Domain\Bus\Request\Request;
use Mockery;
use Monolog\Test\TestCase;

class TransactionalApplicationServiceDecoratorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExecuteTransactionalOperation(): void
    {
        $request = Mockery::mock(Request::class);
        $session = Mockery::mock(TransactionalSession::class)->shouldIgnoreMissing();
        $service = Mockery::mock(ApplicationServiceInterface::class)->shouldIgnoreMissing();
        $session->expects()->executeTransactionalOperation(Mockery::on(
            function ($callback): void {
                $callback();
            }
        ));

        $transactionalApplicationServiceDecorator = new TransactionalApplicationServiceDecorator($service, $session);
        $transactionalApplicationServiceDecorator->execute($request);
    }
}
