<?php

use HmiTech\Cms\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::prefix('cms')
    ->middleware('api')
    ->name('cms.')
    ->group(function (): void {
        Route::prefix('template')->name('template.')->group(function (): void {
            Route::put('/{template}/{section}/settings', [TemplateController::class, 'update'])->name('update');
        });
    });
