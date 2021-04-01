<?php

$preloadCacheFile = dirname(__DIR__) . '/var/cache/prod/Masfernandez_MusicLabelApp_Catalog_Infrastructure_Backend_KernelProdContainer.preload.php';
if (file_exists($preloadCacheFile)) {
    /** @noinspection PhpIncludeInspection */
    /** @noinspection PreloadingUsageCorrectnessInspection */
    require $preloadCacheFile;
}
