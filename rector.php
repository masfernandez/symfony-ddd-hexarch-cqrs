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
        __DIR__ . '/apps/MusicLabelApp/api/src',
    ]);

    // todo Fix bellow classes and remove Skip
    $parameters->set(Option::SKIP, [
        __DIR__ . '/src/Shared/Domain/ValueObject/UuidValueObject.php',
        __DIR__ . '/src/Auth/Domain/User/Token.php',
        __DIR__ . '/src/Auth/Domain/User/User.php',
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [
        'apps/MusicLabelApp/api/config/bootstrap.php',
    ]);

    // SYMFONY CONTAINER
    $path = __DIR__ . '/apps/MusicLabelApp/api/var/cache';
    $kernel_dev_file = $path . '/dev/Masfernandez_MusicLabelApp_Infrastructure_Api_KernelDevDebugContainer.xml';
    $kernel_test_file = $path . '/test/Masfernandez_MusicLabelApp_Infrastructure_Api_KernelTestDebugContainer.xml';
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

    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::PHP_80);

    $parameters->set(Option::ENABLE_CACHE, true);
    $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, getcwd() . '/phpstan.neon');
};
