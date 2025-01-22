<?php

namespace HmiTech\Cms\Providers;

use HmiTech\Cms\Database\Models\TemplateSettings;
use Illuminate\Support\Facades\Context;
use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
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
            'cmsTemplates'     => config('cms.templates'),
            'templateSettings' => Context::getHidden('templateSettings'),
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
            $packagePath . '/config/cms.php' => config_path('cms.php'),
        ], 'config');

        $this->publishes([
            $sourcePath . '/resources/views' => resource_path('views/vendor/cms'),
            $sourcePath . '/resources/js' => resource_path('js/vendor/cms'),
        ], 'vite-assets');
    }
}
