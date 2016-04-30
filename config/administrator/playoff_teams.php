<?php

/**
 * Teams model config.
 */

return [

    'title' => 'Playoff Teams',

    'single' => 'team',

    'model' => 'Nhlstats\Http\Models\PlayoffTeams',

    /*
     * The display columns
     */
    'columns' => [
        'id',
        'round' => [
            'title' => 'round',
        ],
        'conference' => [
            'title' => 'Conference',
        ],
        'team1' => [
            'title'        => 'Team 1',
            'relationship' => 'team1',
            'select'       => "CONCAT((:table).city, ' ', (:table).name)",
        ],
        'team1_position' => [
            'title' => 'Position',
        ],
        'team2' => [
            'title'        => 'Team 2',
            'relationship' => 'team2',
            'select'       => "CONCAT((:table).city, ' ', (:table).name)",
        ],
        'team2_position' => [
            'title' => 'Position',
        ],
        'year' => [
            'title' => 'Year',
        ],
    ],

    /*
     * The filter set
     */
    'filters' => [
        'round' => [
            'title' => 'round',
        ],
        'conference' => [
            'title' => 'Conference',
        ],
        'year' => [
            'title' => 'Year',
        ],
    ],

    /*
     * The editable fields
     */
    'edit_fields' => [
        'round' => [
            'title' => 'round',
        ],
        'conference' => [
            'title' => 'Conference',
        ],
        'team1' => [
            'title'      => 'Team 1',
            'type'       => 'relationship',
            'name_field' => 'city_and_name',
            'options_filter' => function ($query) {
                $query->where('year', config('nhlstats.currentYear'));
            },
        ],
        'team2' => [
            'title'      => 'Team 2',
            'type'       => 'relationship',
            'name_field' => 'city_and_name',
            'options_filter' => function ($query) {
                $query->where('year', config('nhlstats.currentYear'));
            },
        ],
    ],

    'sort' => [
        'field'     => 'round',
        'direction' => 'asc',
    ],
];
