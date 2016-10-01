<?php

Route::get('api', function () {
    return redirect('doc/index.html');
});

/// API
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function () use ($api) {
    $api->group(['namespace' => 'Nhlstats\Http\Controllers\Api'], function () use ($api) {
        $api->get('teams', ['as' => 'api.index.teams', 'uses' => 'TeamsController@index']);
        $api->get('teams/{id}', ['as' => 'api.show.teams', 'uses' => 'TeamsController@show']);
        $api->get('scores/{date?}', ['as' => 'api.get.scores', 'uses' => 'ScoresController@get']);
    });
});
