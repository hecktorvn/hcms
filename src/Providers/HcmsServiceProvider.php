<?php

namespace HmiTech\Hcms\Providers;

use HmiTech\Hcms\Services\HcmsService;
use Illuminate\Support\ServiceProvider;

class HcmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'hcms');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->configurePublishes();
    }

    public function register(): void
    {
        $this->app->singleton(HcmsService::class, fn() => new HcmsService());
    }

    public function configurePublishes(): void
    {
        $packagePath = __DIR__ . '/../..';
        $sourcePath  = __DIR__ . '/..';

        $this->publishes([
            $packagePath . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            $packagePath . '/config/hcms.php' => config_path('hcms.php'),
        ], 'config');

        $this->publishes([
            $sourcePath . '/resources/views' => resource_path('views/vendor/hcms'),
            $sourcePath . '/resources/js' => resource_path('js/vendor/hcms'),
        ], 'vite-assets');
    }
}
