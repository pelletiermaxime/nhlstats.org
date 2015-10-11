<?hh

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;
use Carbon\Carbon;

class PlayerPageController extends Controller
{
    /**
     * Show info and daily stats for a player
     * @param  int    $id   player_id
     * @param  string $name player's full_name
     * @return View
     */
    public function index(mixed $id, string $name)
    {
        $enemies = [];

        $playerStatsDays = Models\PlayersStatsDays::wherePlayerId($id)
            ->where('day' , '>', '2014-10-18')
            ->orderBy('day', 'DESC')
            ->get()
            ;

        $playerStatsYear = Models\PlayersStatsYear::wherePlayerId($id)
            ->first()
            ;

        $player = Models\Player::find($id);

        $games = Models\GameScores::whereRaw("team1_id = {$player->team->id} OR team2_id = {$player->team->id}")
            ->with(['team1', 'team2'])
            ->get()
            ;

        foreach ($games as $id => $game) {
            if ($game->team1_id == $player->team->id) {
                $enemyTeam = $game->team2;
            } else {
                $enemyTeam = $game->team1;
            }
            $enemies[$game['date_game']] = $enemyTeam;
        }

        return view('players.page')
            ->withStatsDays($playerStatsDays)
            ->withStatsYear($playerStatsYear)
            ->withPlayer($player)
            ->withEnemies($enemies)
        ;
    }
}
