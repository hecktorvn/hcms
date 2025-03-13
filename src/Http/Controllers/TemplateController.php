<?php

namespace HmiTech\Hcms\Http\Controllers;

use HmiTech\Hcms\Database\Models\TemplateSettings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TemplateController extends Controller
{
    public function update(Request $request, string $templateName, string $sectionName): TemplateSettings
    {
        return TemplateSettings::updateOrCreate([
            'template' => $templateName,
            'section' => $sectionName,
        ], [
            'config' => $request->all(),
        ]);
    }
}
