<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;

class ApiController extends Controller
{
    public function __construct()
    {
    }

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

    /**
     * Show a team
     *
     * Get a JSON representation of a specific team.
     *
     * @Get("api/team/{id}")
     * @Response(200, body={"team":{"id":31,"short_name":"DET","city":"Detroit","name":"Red Wings","division_id":5}})
     * @Parameters({
     *     @Parameter("id:31", type="integer", required=true, description="ID of the team.")
     * })
     * @Versions({"v1"})
     */
    public function team_get($id)
    {
        return Models\Team::findOrFail($id);
    }
}
