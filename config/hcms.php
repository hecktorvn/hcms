<?php

return [
    'templates' => [
        "exemplo-1" => [
            "name"        => "Exemplo 1",
            "slug"        => "exemplo-1",
            "description" => "Exemplo 1 descrição",
            "path"        => __DIR__ . "/../views/template-example",
            "sections"    => [
                'header' => [
                    "name"        => "Header",
                    "description" => "Header do template",
                    "fields"       => [
                        "title" => [
                            "type"        => "input",
                            "label"       => "Título"
                        ]
                    ]
                ],
            ]
        ]
    ]
];
