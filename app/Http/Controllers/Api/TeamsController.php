<?php

namespace Nhlstats\Http\Controllers\Api;

use Nhlstats\Http\Controllers\Controller;
use Nhlstats\Http\Models;

/**
 * @Resource("Teams", uri="/api/teams")
 */
class TeamsController extends Controller
{
    /**
     * Show all teams
     *
     * @Get
     * @Versions({"v1"})
     * @Response(200, body={"teams":{{"id":31,"short_name":"DET","city":"Detroit","name":"Red Wings","division_id":5}}})
     */
    public function index()
    {
        return Models\Team::all(['id', 'short_name', 'city', 'name', 'division_id']);
    }

    /**
     * Show a team
     *
     * @Get("/{id}")
     * @Response(200, body={"team":{"id":31,"short_name":"DET","city":"Detroit","name":"Red Wings","division_id":5}})
     * @Parameters({
     *     @Parameter("id:31", type="integer", required=true, description="ID of the team.")
     * })
     * @Versions({"v1"})
     */
    public function show($id)
    {
        return Models\Team::findOrFail($id);
    }
}
