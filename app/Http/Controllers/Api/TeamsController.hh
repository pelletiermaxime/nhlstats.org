<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models;

/**
 * @Resource("Teams", uri="/api/teams")
 */
class TeamsController extends Controller
{
    /**
     * Show all teams
     *
     * Get a JSON representation of all the teams.
     *
     * @Get("api/teams")
     * @Versions({"v1"})
     * @Response(200, body={"teams":{{"id":31,"short_name":"DET","city":"Detroit","name":"Red Wings","division_id":5}}})
     */
    public function teams_get()
    {
        return Models\Team::all(['id', 'short_name', 'city', 'name', 'division_id']);
    }
}
