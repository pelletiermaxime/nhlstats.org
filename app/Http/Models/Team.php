<?php

namespace app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function division()
    {
        return $this->belongsTo('Division');
    }

    public function byDivision()
    {
        $query = \DB::table('teams')
            ->where('teams.year', \Config::get('nhlstats.currentYear'))
            ->join('divisions', 'divisions.id', '=', 'teams.division_id')
            ->orderBy('conference', 'ASC')
            ->orderBy('division', 'ASC')
        ;
        $teams = $query->get();

        // Put in sub-arrays by division
        $teamsByDivision = [];
        foreach ($teams as $team) {
            $teamsByDivision[$team->division][] = $team;
        }

        return $teamsByDivision;
    }

    public function getWithShortNameAndCity()
    {
        $query = \DB::table('teams')
            ->select('city', 'short_name', 'name')
            ->orderBy('city', 'ASC')
        ;
        $teams = $query->get();
        foreach ($teams as $team) {
            $listTeam[$team->short_name] = "{$team->city} {$team->name}";
        }

        return $listTeam;
    }
}
