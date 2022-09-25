<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets(
        [
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::TYPE_DECLARATION,
            SetList::PHP_81,
        ]
    );

    $rectorConfig->paths(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
            __DIR__ . '/apps/MusicLabel/api/src',
        ]
    );

    $rectorConfig->skip(
        [
            // paths @todo
            __DIR__ . '/apps/MusicLabel/api/src/Repository/Cache/Redis/Client.php',
            __DIR__ . '/src/Shared/Domain/ValueObject/UuidValueObject.php',
            __DIR__ . '/src/Store/Auth/Domain/User/Token.php',
            __DIR__ . '/src/Store/Auth/Domain/User/User.php',
            __DIR__ . '/src/Backoffice/Catalog/Domain/Album/Album.php',
            __DIR__ . '/src/Backoffice/Catalog/Domain/Album/Album.php',

            // Rules @todo
            RemoveUnusedPromotedPropertyRector::class,
            ReadOnlyPropertyRector::class,
        ]
    );

    $rectorConfig->autoloadPaths(
        [
            'apps/MusicLabel/api/config/bootstrap.php',
        ]
    );

    // symfony container
    $path             = __DIR__ . '/apps/MusicLabel/api/var/cache';
    $kernel_dev_file  = $path . '/dev/Masfernandez_MusicLabel_Infrastructure_Api_KernelDevDebugContainer.xml';
    $kernel_test_file = $path . '/test/Masfernandez_MusicLabel_Infrastructure_Api_KernelTestDebugContainer.xml';
    if (file_exists($kernel_dev_file)) {
        $container = $kernel_dev_file;
    } elseif (file_exists($kernel_test_file)) {
        $container = $kernel_test_file;
    } else {
        print sprintf('Symfony container path does not exist. Current path is: %s' . PHP_EOL, $kernel_dev_file);
        exit();
    }
    $rectorConfig->symfonyContainerXml($container);

    // php-stan
    $rectorConfig->phpstanConfig(getcwd() . '/phpstan.neon');
};