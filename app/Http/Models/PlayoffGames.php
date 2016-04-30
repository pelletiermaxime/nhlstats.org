<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlayoffGames extends Model
{
    /**
     * Return all playoff games for a conference and a round.
     *
     * @param $conference EAST|WEST
     * @param $round
     *
     */
    public function byConference(string $conference, int $round = 1)
    {
        $gamesEast = Cache::remember('playoffGames_' . $conference, 60, function () {
            return PlayoffTeams::whereConference($conference)
                ->with('Team1')
                ->with('Team2')
                ->get()
                ->toArray();
        });
    }
}
