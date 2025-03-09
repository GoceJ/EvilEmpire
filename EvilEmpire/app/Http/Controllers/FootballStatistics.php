<?php

namespace App\Http\Controllers;

use App\Models\FootballGame;
use App\Models\FootballTeam;
use Illuminate\Http\Request;

trait FootballStatistics {

    public function allGames($home, $away) {
        $gamesData = FootballGame::where([
            ['t1_id', '=', $home],
            ['t2_id', '=', $away]
        ])->get();

        $result = [];
        foreach ($gamesData as $data) {
            $hd = [
                't1' => $data->t1name->name,
                't2' => $data->t2name->name,
            ];

            array_push($result, $hd);
        }

        return $result;
    }
    
    public function bySeason($home, $leagueId, $away = null) {
        if ($away == null) {
            $gamesData = FootballGame::where([
                ['t1_id', '=', $home],
                ['league_id', '=', $leagueId]
            ])->get();
        } else {
            $gamesData = FootballGame::where([
                ['t1_id', '=', $home],
                ['t2_id', '=', $away],
                ['league_id', '=', $leagueId]
            ])->get();
        }

        $result = [];
        foreach ($gamesData as $data) {
            $hd = [
                't1' => $data->t1name->name,
                't2' => $data->t2name->name,
                'league_name' => $data->league->name
            ];

            array_push($result, $hd);
        }

        return $result;
    }


}
