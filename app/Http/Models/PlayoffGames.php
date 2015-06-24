<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlayoffGames extends Model
{
    /**
     * Return all playoff games for a conference and a round.
     *
     * @param string $conference EAST|WEST
     * @param int    $round
     *
     * @return [type] [description]
     */
    public function byConference($conference, $round = 1)
    {
        $gamesEast = Cache::remember('playoffGames_'.$conference, 60, function () {
        return PlayoffTeams::whereConference($conference)
            ->with('Team1')
            ->with('Team2')
            ->get()
            ->toArray();
        });
    }
}
