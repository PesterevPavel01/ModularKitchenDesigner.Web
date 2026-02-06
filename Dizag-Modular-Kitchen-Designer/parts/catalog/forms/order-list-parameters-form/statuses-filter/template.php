<?get_template_part("/parts/controls/fieldset/template", null,
    [
        'TITLE' =>  'СТАТУСЫ',
        'LIST_NAME' => 'statuses',
        'ITEMS' => [
            [ 
                'NAME' => 'Черновик',
                'VALUE' => '1'
            ],
            [ 
                'NAME' => 'На согласовании',
                'VALUE' => '2'
            ],
            [ 
                'NAME' => 'Согласован',
                'VALUE' => '3'
            ],
            [ 
                'NAME' => 'Передан в производство',
                'VALUE' => '4'
            ],
            [ 
                'NAME' => 'Не принят в производство',
                'VALUE' => '5'
            ],
            [ 
                'NAME' => 'Производство завершено',
                'VALUE' => '6'
            ],
            [ 
                'NAME' => 'Завершен',
                'VALUE' => '9'
            ],
        ],
        'MAIN_CONTEINER_CLASS' => 'statuses-filter-conteiner',
        'CONTENT_CONTEINER_CLASS' => 'statuses-filter-content'
    ]);