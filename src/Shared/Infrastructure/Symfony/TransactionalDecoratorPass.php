<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Infrastructure\Symfony;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Application\Service\TransactionalApplicationServiceDecorator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TransactionalDecoratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(TransactionalApplicationServiceDecorator::class)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('application_service');
        foreach (array_keys($taggedServices) as $service) {
            if ($service === TransactionalApplicationServiceDecorator::class) {
                continue;
            }

            [$alias, $argument] = $this->generateAliasName($service);

            // Add the new decorated service.
            $container->register($alias, TransactionalApplicationServiceDecorator::class)
                ->setDecoratedService($service)
                ->setPublic(false)
                ->setAutowired(true)
                ->setAutoconfigured(true);

            // Add the named autowiring alias for wiring with argument
            $container->setAlias(ApplicationServiceInterface::class . " $$argument", $alias);
        }
    }

    /**
     * @return string[]
     */
    private function generateAliasName(string $serviceName): array
    {
        if (str_contains($serviceName, '\\')) {
            $parts = explode('\\', $serviceName);
            $className = end($parts);
        } else {
            $className = $serviceName;
        }
        $alias = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($className)));
        $argument = lcfirst($className);
        return [
            $alias . '_transactional_decorated',
            $argument
        ];
    }
}
