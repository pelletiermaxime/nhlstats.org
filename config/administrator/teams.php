<?php

/**
 * Teams model config.
 */

return [

    'title' => 'Teams',

    'single' => 'team',

    'model' => 'App\Http\Models\Team',

    /*
     * The display columns
     */
    'columns' => [
        'short_name' => [
            'title' => 'Logo',
            'output' => '<img src="/images/SVG/(:value).svg" height="35" />',
        ],
        'city' => [
            'title' => 'City',
        ],
        'name' => [
            'title' => 'Name',
        ],
        'year' => [
            'title' => 'Year',
        ],
    ],

    /*
     * The filter set
     */
    'filters' => [
        'city' => [
            'title' => 'City',
        ],
        'name' => [
            'title' => 'Name',
        ],
        'year' => [
            'title' => 'Year',
        ],
    ],

    /*
     * The editable fields
     */
    'edit_fields' => [
        'city' => [
            'title' => 'City',
            'type' => 'text',
        ],
        'name' => [
            'title' => 'Name',
        ],
        'year' => [
            'title' => 'Year',
            'type' => 'text',
        ],
    ],

    'sort' => array(
        'field' => 'city',
        'direction' => 'asc',
    ),
];
