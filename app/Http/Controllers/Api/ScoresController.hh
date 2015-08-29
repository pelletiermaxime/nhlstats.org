<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models;

/**
 * @Resource("Scores", uri="/api/scores")
 */
class ScoresController extends Controller
{
    /**
     * Show all scores
     *
     * Get a JSON representation of the scores of a day. Defaults to today.
     *
     * @Get("/{date}")
     * @Versions({"v1"})
     * @Response(200, body={
     * "game_scores":{{
     *     "team1_id": "56", "score1_1": "0", "score1_2": "0", "score1_3": "1",
     *     "score1_OT": "0", "score1_SO": null, "score1_T": "1",
     *     "team2_id": "42", "score2_1": "1", "score2_2": "2", "score2_3": "1",
     *     "score2_OT": "0", "score2_SO": null, "score2_T": "4",
     *     "date_game": "2015-05-12",
     *     "year": "1415",
     *     "team1":
     *     {
     *         "id": "56",
     *         "short_name": "MTL",
     *         "city": "Montreal",
     *         "name": "Canadiens",
     *         "year": "1415",
     *         "division_id": "5"
     *     },
     *     "team2":
     *     {
     *         "id": "42",
     *         "short_name": "TBL",
     *         "city": "Tampa Bay",
     *         "name": "Lightning",
     *         "year": "1415",
     *         "division_id": "5"
     *     }
     * }}
     * })
     * @Parameters({
     *     @Parameter("date:`2015-05-12`", type="string", required=false, description="Date of the scores. Defaults to today.")
     * })
     */

    public function get($date = null)
    {
        $dates = Models\DateHelper::getDates($date);
        $scores = Models\GameScores::whereDateGame($dates['today'])
            ->with(['team1', 'team2'])
            ->get()
        ;
        return $scores;
    }
}
