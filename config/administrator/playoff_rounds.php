<?php

/**
 * Teams model config.
 */

return [

    'title' => 'Playoff Rounds',

    'single' => 'round',

    'model' => 'Nhlstats\Http\Models\PlayoffRounds',

    /*
     * The display columns
     */
    'columns' => [
        'id',
        'round' => [
            'title' => 'Round',
        ],
        'date_start' => [
            'title' => 'Starting date',
        ],
        'date_end' => [
            'title' => 'Ending date',
        ],
        'year' => [
            'title' => 'Year',
        ],
    ],

    /*
     * The filter set
     */
    'filters' => [
        'year' => [
            'title'   => 'Year',
            'type'    => 'enum',
            'options' => [
                '1415' => '2014-2015',
            ],
        ],
        'round' => [
            'title'   => 'Round',
            'type'    => 'enum',
            'options' => ['1', '2', '3', '4'],
        ],
    ],

    /*
     * The editable fields
     */
    'edit_fields' => [
        'year' => [
            'title'   => 'Year',
            'type'    => 'enum',
            'options' => [
                '1415 ' => '2014-2015',
            ],
        ],
        'round' => [
            'title'   => 'Round',
            'type'    => 'enum',
            'options' => ['1', '2', '3', '4'],
        ],
        'date_start' => [
            'title' => 'Starting date',
            'type'  => 'date',
        ],
        'date_end' => [
            'title' => 'Ending date',
            'type'  => 'date',
        ],
    ],

    'sort' => [
        'field'     => 'year',
        'direction' => 'asc',
    ],
];
