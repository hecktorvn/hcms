<?php

namespace Hcms\Database\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSettings extends Model {
    protected $guarded = ['id'];

    protected $casts = [
        'config' => 'array',
    ];
}
