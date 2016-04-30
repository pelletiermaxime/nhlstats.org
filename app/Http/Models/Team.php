<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    public function division()
    {
        return $this->belongsTo('Nhlstats\Http\Models\Division');
    }

    public function getCityAndNameAttribute()
    {
        return $this->city . ' ' . $this->name;
    }

    public static function byDivision(int $year)
    {
        $query = DB::table('teams')
            ->where('teams.year', $year)
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

    public static function getWithShortNameAndCity()
    {
        $listTeam = [];
        $query = DB::table('teams')
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
