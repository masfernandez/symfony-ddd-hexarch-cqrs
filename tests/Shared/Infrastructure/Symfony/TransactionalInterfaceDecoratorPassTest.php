<?php

declare(strict_types=1);

namespace Masfernandez\Tests\Shared\Infrastructure\Symfony;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Application\Service\TransactionalApplicationServiceDecorator;
use Masfernandez\Shared\Application\Service\TransactionalSession;
use Masfernandez\Shared\Infrastructure\Symfony\TransactionalDecoratorPass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TransactionalInterfaceDecoratorPassTest extends KernelTestCase
{
    /**
     * @test
     */
    public function testDecoratingApplicationServices(): void
    {
        $container = new ContainerBuilder();

        $container
            ->register(TransactionalApplicationServiceDecorator::class)
            ->setPublic(true)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->addTag('application_service')
            ->setArgument('$service', new Reference(ApplicationServiceInterface::class))
            ->setArgument('$session', new Reference(TransactionalSession::class));

        $container
            ->register('Masfernandez\Tests\Shared\Infrastructure\Symfony\UseCaseApplicationService')
            ->setPublic(true)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->addTag('application_service');

        $container
            ->register('OtherUseCaseApplicationService')
            ->setPublic(true)
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->addTag('application_service');

        $this->process($container);

        self::assertTrue($container->hasDefinition('use_case_application_service_transactional_decorated'));
        self::assertTrue($container->hasDefinition('other_use_case_application_service_transactional_decorated'));
        self::assertTrue($container->hasAlias(ApplicationServiceInterface::class . ' $useCaseApplicationService'));
        self::assertTrue($container->hasAlias(ApplicationServiceInterface::class . ' $otherUseCaseApplicationService'));
    }

    protected function process(ContainerBuilder $container): void
    {
        (new TransactionalDecoratorPass())->process($container);
    }

    /**
     * @test
     */
    public function testDecoratorPass(): void
    {
        $container = new ContainerBuilder();
        $this->process($container);
        self::assertFalse($container->hasDefinition(TransactionalDecoratorPass::class));
    }
}
