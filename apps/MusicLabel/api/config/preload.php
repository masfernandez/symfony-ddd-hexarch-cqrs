<?php

$preloadCacheFile = dirname(__DIR__) . '/var/cache/prod/Masfernandez_MusicLabel_Infrastructure_Api_KernelProdContainer.preload.php';
if (file_exists($preloadCacheFile)) {
    /** @noinspection PreloadingUsageCorrectnessInspection */
    require $preloadCacheFile;
}
