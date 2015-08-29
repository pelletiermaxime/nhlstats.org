<?hh

Route::get('api', () ==> {
    return redirect('doc/index.html');
});

/// API
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', () ==> {
    $api->group(['namespace' => 'App\Http\Controllers\Api'], () ==> {
        $api->get('teams', ['as' => 'api.get.teams', 'uses' =>'TeamsController@get']);
        $api->get('team/{id}', ['as' => 'api.get.team', 'uses' =>'TeamController@get']);
        $api->get('scores/{date?}', ['as' => 'api.get.scores', 'uses' =>'ScoresController@get']);
    });
});
