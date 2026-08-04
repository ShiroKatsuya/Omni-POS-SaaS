<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$basePath = dirname(__DIR__);
$storagePath = $_SERVER['APP_STORAGE'] ?? $_ENV['APP_STORAGE'] ?? getenv('APP_STORAGE') ?: $basePath.'/storage';

if (! is_dir($storagePath) || ! is_writable($storagePath)) {
    $storagePath = sys_get_temp_dir().'/laravel_storage';
}

$bootstrapStoragePath = $storagePath.'/bootstrap';
$bootstrapCachePath = $bootstrapStoragePath.'/cache';

foreach ([
    $storagePath,
    $storagePath.'/app',
    $storagePath.'/framework',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/testing',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
    $bootstrapStoragePath,
    $bootstrapCachePath,
] as $path) {
    if (! is_dir($path) && ! @mkdir($path, 0777, true) && ! is_dir($path)) {
        error_log('Unable to create writable path: '.$path);
    }
}

if (is_dir($bootstrapCachePath)) {
    foreach (glob($bootstrapCachePath.'/*.php') as $cacheFile) {
        if (basename($cacheFile) === '.gitignore') {
            continue;
        }

        if (is_file($cacheFile)) {
            @unlink($cacheFile);
            error_log('Purging stale bootstrap cache: '.$cacheFile);
        }
    }
}

if (file_exists($maintenance = $basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $basePath.'/vendor/autoload.php';

$app = require_once $basePath.'/bootstrap/app.php';
$app->useStoragePath($storagePath);
$app->useBootstrapPath($bootstrapStoragePath);

try {
    error_log('Bootstrap diagnostics: basePath='.$app->basePath());
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    error_log('Bootstrap diagnostics: kernel='.get_class($kernel));
    $kernel->bootstrap();
    error_log('Bootstrap diagnostics: kernel bootstrap complete');

    if ($app->bound('config')) {
        $config = $app->make('config');
        error_log('Bootstrap diagnostics: app.providers='.json_encode($config->get('app.providers')));
        error_log('Bootstrap diagnostics: view bound=' . ($app->bound('view') ? 'yes' : 'no'));
    } else {
        error_log('Bootstrap diagnostics: config not bound');
    }

    $app->handleRequest(Request::capture());
} catch (Throwable $throwable) {
    $chain = [];
    for ($current = $throwable; $current !== null; $current = $current->getPrevious()) {
        $chain[] = sprintf(
            '%s: %s in %s:%d',
            $current::class,
            $current->getMessage(),
            $current->getFile(),
            $current->getLine()
        );
    }

    error_log('Laravel entrypoint failure chain: '.implode(' | ', $chain));

    throw $throwable;
}
