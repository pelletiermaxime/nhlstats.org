<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models;

/**
 * @Resource("Team", uri="/api/team/{id}")
 */
class TeamController extends Controller
{
    /**
     * Show a team
     *
     * Get a JSON representation of a specific team.
     *
     * @Get
     * @Response(200, body={"team":{"id":31,"short_name":"DET","city":"Detroit","name":"Red Wings","division_id":5}})
     * @Parameters({
     *     @Parameter("id:31", type="integer", required=true, description="ID of the team.")
     * })
     * @Versions({"v1"})
     */
    public function get($id)
    {
        return Models\Team::findOrFail($id);
    }
}
