<?php

/**
 * Teams model config.
 */

return [

    'title' => 'Playoff Teams',

    'single' => 'team',

    'model' => 'App\Http\Models\PlayoffTeams',

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
            'name_field' => 'name',
        ],
        'team1_position' => [
            'title' => 'Position team 1',
        ],
        'team2' => [
            'title'      => 'Team 2',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
        'team2_position' => [
            'title' => 'Position team 2',
        ],
    ],

    'sort' => [
        'field'     => 'round',
        'direction' => 'asc',
    ],
];
