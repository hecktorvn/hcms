<?php

namespace Hecktorvn\Hcms\Services;

use Hecktorvn\Hcms\Database\Models\TemplateSettings;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Schema;

class HcmsService
{
    static string $currentTemplate = 'default';

    public static function setCurrentTemplate(string $template): void
    {
        self::$currentTemplate = $template;
    }

    public static function getConfig(): array
    {
        $templateSettings = [];
        
        if(Schema::hasTable('template_settings')) {
            $templateSettings = TemplateSettings::get()->groupBy('template')->toArray();
            Context::addHidden('templateSettings', $templateSettings);
        }

        return [
            'currentTemplate' => static::$currentTemplate,
            'templates'       => static::getTemplates(),
            'settings'        => $templateSettings,
        ];
    }

    public static function getTemplates(): array
    {
        return config('hcms.templates');
    }
}