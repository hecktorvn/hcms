<?php

use Hecktorvn\Hcms\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::prefix('cms')
    ->middleware([
        'api',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ])
    ->name('cms.')
    ->group(function (): void {
        Route::prefix('template')->name('template.')->group(function (): void {
            Route::put('/{template}/{section}/settings', [TemplateController::class, 'update'])->name('update');
        });
    });
