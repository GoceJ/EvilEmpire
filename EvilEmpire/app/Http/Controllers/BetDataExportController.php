<?php

namespace App\Http\Controllers;

use App\Models\BasketballGame;
use App\Models\BasketballTeam;
use App\Models\FootballGame;
use App\Models\FootballTeam;
use Illuminate\Http\Request;

class BetDataExportController extends Controller
{
    public function index()
    {
        return view('pages.betDataExport.index');
    }

    public function dataCompare(Request $request)
    {
        $data = json_decode($request->getContent());

        $games = [];
        foreach ($data as $value) {
            $data = $this->forData($value->team1, $value->team2);
            // $reverse = $this->forData($value->team2, $value->team1);

            array_merge($games, $data);
        }

        for ($i = 0; $i < sizeof($games) - 1; $i++) {
            for ($j = $i + 1; $j < sizeof($games); $j++) {
                if ($games[$j]['points']['games'] > $games[$i]['points']['games']) {
                    $temp = $games[$i];
                    $games[$i] = $games[$j];
                    $games[$j] = $temp;
                }
            }
        }

        return json_encode(['data' => $games]);
    }

    private function forData($t1n, $t2n)
    {
        $t1 = FootballTeam::where('name', $t1n)->get();
        $t2 = FootballTeam::where('name', $t2n)->get();

        if (sizeof($t1) == 0 || sizeof($t2) == 0) {
            return [];
        } else {
            $t1Id = $t1[0]->id;
            $t2Id = $t2[0]->id;
        }

        $gamesData = FootballGame::where([
            ['t1_id', '=', $t1Id],
            ['t2_id', '=', $t2Id]
        ])->get();

        if (sizeof($gamesData) == 0) {
            return [];
        } else {
            $check = [
                'team1' => $gamesData[0]->t1name->name,
                'team2' => $gamesData[0]->t2name->name,
                'points' => $this->finalTip($gamesData)
            ];
            return $check;
        }
    }

    private function finalTip($matches)
    {
        $team1wins = 0;
        $draws = 0;
        $team2wins = 0;

        $t1orX = 0;
        $t2orX = 0;

        $t1t1 = 0;
        $t2t2 = 0;

        $totalScore0_2 = 0;
        $totalScore3x = 0;
        $totalScore4x = 0;

        $scorescore = 0;
        $scorescore3x = 0;

        $t12x = 0;
        $t22x = 0;

        $t1and3x = 0;
        $t2and3x = 0;

        $gamesCounter = 0;
        foreach ($matches as $playedGames) {
            if ($playedGames->points->t1_total == '' || $playedGames->points->t2_total == '') {
                continue;
            }

            $gamesCounter++;
            // 1 X 2
            if ($playedGames->points->t1_total > $playedGames->points->t2_total) {
                $team1wins = $team1wins + 1;
            } else if ($playedGames->points->t1_total == $playedGames->points->t2_total) {
                $draws = $draws + 1;
            } else if ($playedGames->points->t2_total > $playedGames->points->t1_total) {
                $team2wins = $team2wins + 1;
            }

            // 1-X 2-X
            if ($playedGames->points->t1_total >= $playedGames->points->t2_total) {
                $t1orX = $t1orX + 1;
            }
            if ($playedGames->points->t2_total >= $playedGames->points->t1_total) {
                $t2orX = $t2orX + 1;
            }

            // 1-1 2-2
            if (
                $playedGames->points->t1_total > $playedGames->points->t2_total
                && $playedGames->points->t1_1half > $playedGames->points->t2_1half
            ) {
                $t1t1 = $t1t1 + 1;
            } else if (
                $playedGames->points->t1_total < $playedGames->points->t2_total
                && $playedGames->points->t1_1half < $playedGames->points->t2_1half
            ) {
                $t2t2 = $t2t2 + 1;
            }

            // 0-2	3+	4+
            $totalPoints = $playedGames->points->t1_total + $playedGames->points->t2_total;
            if ($totalPoints >= 0 && $totalPoints <= 2) {
                $totalScore0_2 = $totalScore0_2 + 1;
            }
            if ($totalPoints >= 3) {
                $totalScore3x = $totalScore3x + 1;
            }
            if ($totalPoints >= 4) {
                $totalScore4x = $totalScore4x + 1;
            }

            // ГГ	ГГ 3+	
            if (
                $playedGames->points->t1_total > 0
                && $playedGames->points->t2_total > 0
            ) {
                $scorescore = $scorescore + 1;
            }
            if (
                $playedGames->points->t1_total > 0
                && $playedGames->points->t2_total > 0
                && $totalPoints >= 3
            ) {
                $scorescore3x = $scorescore3x + 1;
            }

            // Т1 2+	Т2 2+	
            if (
                $playedGames->points->t1_total >= 2
            ) {
                $t12x = $t12x + 1;
            } else if ($playedGames->points->t2_total >= 2) {
                $t22x = $t22x + 1;
            }

            // 1&3+	2&3+
            if (
                $playedGames->points->t1_total > $playedGames->points->t2_total
                && $totalPoints >= 3
            ) {
                $t1and3x = $t1and3x + 1;
            } else if (
                $playedGames->points->t1_total < $playedGames->points->t2_total
                && $totalPoints >= 3
            ) {
                $t2and3x = $t2and3x + 1;
            }
        }

        return [
            '1' => $team1wins,
            'X' => $draws,
            '2' => $team2wins,
            '1X' => $t1orX,
            '2X' => $t2orX,
            '1-1' => $t1t1,
            '2-2' => $t2t2,
            '0-2' => $totalScore0_2,
            '3+' => $totalScore3x,
            '4+' => $totalScore4x,
            'GG' => $scorescore,
            'GG3+' => $scorescore3x,
            'T12+' => $t12x,
            'T22+' => $t22x,
            '1&3+' => $t1and3x,
            '2&3+' => $t2and3x,
            'games' => $gamesCounter
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
