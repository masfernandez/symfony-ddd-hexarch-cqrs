<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/apps/MusicLabelApp/backend/src',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/src/Shared/Domain/ValueObject/UuidValueObject.php',
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [
        'apps/MusicLabelApp/backend/config/bootstrap.php',
    ]);

    // SYMFONY CONTAINER
    $path = __DIR__ . '/apps/MusicLabelApp/backend/var/cache';
    $kernel_dev_file = $path . '/dev/Masfernandez_MusicLabelApp_Infrastructure_Backend_KernelDevDebugContainer.xml';
    $kernel_test_file = $path . '/test/Masfernandez_MusicLabelApp_Infrastructure_Backend_KernelTestDebugContainer.xml';
    if (file_exists($kernel_dev_file)) {
        $container = $kernel_dev_file;
    } else if (file_exists($kernel_test_file)) {
        $container = $kernel_test_file;
    } else {
        print sprintf('Symfony container path does not exist. Current path is: %s' . PHP_EOL, $kernel_dev_file);
        exit();
    }
    $parameters->set(
        Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER,
        $container
    );

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::CODE_QUALITY,
        SetList::CONTRIBUTTE_TO_SYMFONY,
        SetList::PHP_80,
    ]);

    $parameters->set(Option::ENABLE_CACHE, true);
    $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, getcwd() . '/phpstan.neon');
};
