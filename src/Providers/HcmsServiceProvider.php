<?php

namespace Hcms\Providers;

use Hcms\Database\Models\TemplateSettings;
use Illuminate\Support\Facades\Context;
use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    static string $currentTemplate = 'default';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'hcms');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->configurePublishes();
        $this->shareTemplateConfig();
    }

    public function register(): void
    {
        // Registra bindings
    }

    public function shareTemplateConfig(): void
    {
        Context::addHidden('templateSettings', function() {
            return TemplateSettings::get()->groupBy('template')->toArray();
        });

        Inertia::share([
            'hcms' => [
                'currentTemplate' => static::$currentTemplate,
                'templates'       => config('hcms.templates'),
                'settings'        => Context::getHidden('templateSettings'),
            ]
        ]);
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
