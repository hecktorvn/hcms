<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_settings', function (Blueprint $table): void {
            $table->id();

            $table->string('template');
            $table->string('section');
            $table->json('config');

            $table->unique(['template', 'section']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_settings');
    }
};
