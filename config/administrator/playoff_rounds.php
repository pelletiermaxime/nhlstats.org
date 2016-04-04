<?php

/**
 * Teams model config.
 */

$year = [
    'title'   => 'Year',
    'type'    => 'enum',
    'options' => [
        '1415' => '2014-2015',
        '1516' => '2015-2016',
    ],
];

$round = [
    'title'   => 'Round',
    'type'    => 'enum',
    'options' => ['1', '2', '3', '4'],
];

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
        'year' => $year,
        'round' => $round,
    ],

    /*
     * The editable fields
     */
    'edit_fields' => [
        'year' => $year,
        'round' => $round,
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
