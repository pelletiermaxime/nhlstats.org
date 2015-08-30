<?hh

Route::get('api', () ==> {
    return redirect('doc/index.html');
});

/// API
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', () ==> {
    $api->group(['namespace' => 'App\Http\Controllers\Api'], () ==> {
        $api->get('teams', ['as' => 'api.index.teams', 'uses' =>'TeamsController@index']);
        $api->get('teams/{id}', ['as' => 'api.show.teams', 'uses' =>'TeamsController@show']);
        $api->get('scores/{date?}', ['as' => 'api.get.scores', 'uses' =>'ScoresController@get']);
    });
});
