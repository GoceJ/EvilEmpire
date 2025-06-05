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

        $result = $this->gamesMath($gamesData);
        

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


     public function gamesMath($gamesData) {
        $arr = $this->gamesData();

        $gamesCounter = 0;

        foreach ($gamesData as $game) {
            if ($game->points->t1_total == '' || $game->points->t2_total == '') {
                continue;
            }

            $gamesCounter++;
            $arr['teamNames']['team1'] = $game->t1name->name;
            $arr['teamNames']['team2'] = $game->t2name->name;

            $t1total = $game->points->t1_total;
            $t2total = $game->points->t2_total;
            $t1half = $game->points->t1_1half;
            $t2half = $game->points->t2_1half;
            $totalGoals = $t1total + $t2total;
            $totalHalf = $t1half + $t2half;

            // *** Конечен Тип ***
            if ($t1total > $t2total) {
                $arr['konecenTip']['1']++;
            } else if ($t1total == $t2total) {
                $arr['konecenTip']['x']++;
            } else if ($t2total > $t1total) {
                $arr['konecenTip']['2']++;
            }

            

            // *** Полувреме/Крај ***
            if ($t1half > $t2half && $t1total > $t2total) {
                $arr['poluvremeKraj']['11']++;
            }

            if ($t1half > $t2half && $t1total == $t2total) {
                $arr['poluvremeKraj']['1x']++;
            }

            if ($t1half > $t2half && $t1total < $t2total) {
                $arr['poluvremeKraj']['12']++;
            }

            if ($t1half == $t2half && $t1total > $t2total) {
                $arr['poluvremeKraj']['x1']++;
            }

            if ($t1half == $t2half && $t1total == $t2total) {
                $arr['poluvremeKraj']['xx']++;
            }

            if ($t1half == $t2half && $t1total < $t2total) {
                $arr['poluvremeKraj']['x2']++;
            }

            if ($t1half < $t2half && $t1total > $t2total) {
                $arr['poluvremeKraj']['21']++;
            }

            if ($t1half < $t2half && $t1total == $t2total) {
                $arr['poluvremeKraj']['2x']++;
            }

            if ($t1half < $t2half && $t1total < $t2total) {
                $arr['poluvremeKraj']['22']++;
            }

            // // *** Вкупно Голови ***
            if ($totalGoals <= 1) {
                $arr['vkupnoGolovi']['01']++;
            }
            if ($totalGoals >= 2) {
                $arr['vkupnoGolovi']['2+']++;
            }
            if ($totalGoals <= 2) {
                $arr['vkupnoGolovi']['02']++;
            }
            if ($totalGoals >= 3) {
                $arr['vkupnoGolovi']['3+']++;
            }
            if ($totalGoals <= 3) {
                $arr['vkupnoGolovi']['03']++;
            }
            if ($totalGoals >= 4) {
                $arr['vkupnoGolovi']['4+']++;
            }
            if ($totalGoals <= 4) {
                $arr['vkupnoGolovi']['04']++;
            }
            if ($totalGoals >= 5) {
                $arr['vkupnoGolovi']['5+']++;
            }
            if ($totalGoals >= 6) {
                $arr['vkupnoGolovi']['6+']++;
            }
            if ($totalGoals >= 7) {
                $arr['vkupnoGolovi']['7+']++;
            }


          


            // // *** Двата Тима Даваат Гол (ГГ/НГ) ***
            // 'dvataTimaDavaatGol' => [
            //     'gg' => 0,
            //     'ng' => 0,
            //     'ggpp' => 0,
            //     'ngpp' => 0,
            //     'ggvp' => 0,
            //     'ngvp' => 0,
            //     '2g2g' => 0,
            // ],

            // // *** Тим 1 Голови ***
            // 'tim1golovi' => [
            //     't10' => 0,
            //     't11+' => 0,
            //     't12+' => 0,
            //     't13+' => 0,
            //     't14+' => 0,
            //     't13g' => 0,
            //     't11>2' => 0,
            //     't12>1' => 0,
            //     't11=2' => 0,
            // ],

            // // *** Тим 2 Голови ***
            // 'tim2golovi' => [
            //     't20' => 0,
            //     't21+' => 0,
            //     't22+' => 0,
            //     't23+' => 0,
            //     't24+' => 0,
            //     't23g' => 0,
            //     't21>2' => 0,
            //     't22>1' => 0,
            //     't21=2' => 0,
            // ],

            // // *** Прво Полувреме ***
            // 'prvoPoluvreme' => [
            //     '1p' => 0,
            //     'xp' => 0,
            //     '2p' => 0,
            // ],

            // // *** Второ Полувреме ***
            // 'vtoroPoluvreme' => [
            //     '1p' => 0,
            //     'xp' => 0,
            //     '2p' => 0,
            // ],

            // // *** Вкупно Голови - Опсег ***
            // 'vkupnoGoloviOpseg' => [
            //     '12' => 0,
            //     '13' => 0,
            //     '14' => 0,
            //     '15' => 0,
            //     '16' => 0,
            //     '23' => 0,
            //     '24' => 0,
            //     '25' => 0,
            //     '26' => 0,
            //     '34' => 0,
            //     '35' => 0,
            //     '26' => 0,
            //     '45' => 0,
            //     '46' => 0,
            // ],

            // // *** Вкупно голови точно ***
            // 'vkupnoGoloviTocno' => [
            //     '1' => 0,
            //     '2' => 0,
            //     '3' => 0,
            //     '4' => 0,
            // ],

            // // *** Вкупно Голови - Прво Полувреме ***
            // 'vkupnoGoloviPP' => [
            //     '0' => 0,
            //     '1+' => 0,
            //     '2+' => 0,
            //     '3+' => 0,
            //     '4+' => 0,
            //     '1' => 0,
            //     '2' => 0,
            // ],

            // // *** Вкупно Голови - Прво Пол. (опсег) ***
            // 'vkupnoGoloviPPopseg' => [
            //     '01' => 0,
            //     '02' => 0,
            //     '12' => 0,
            //     '23' => 0,
            //     '24' => 0,
            //     '13' => 0,
            // ],

            // // *** Вк. Голови - Прво Пол. (исклучок) ***
            // 'vkupnoGoloviPPisklucok' => [
            //     'ne1' => 0,
            //     'ne2' => 0,
            // ]

            // *** Вкупно Голови - Второ Полувреме ***
            // *** Вк. Голови - Второ Пол. (опсег) ***
            // *** Вк. Голови - Второ Пол. (исклучок) ***
            // *** Двојна Шанса ***
            // *** Двојна Шанса Прво Полувреме ***
            // *** Двојна Шанса Второ Полувреме ***
            // *** Конечен Тип - Комбинации ***
            // *** Полувреме/Крај - Комбинации ***
            // *** Полувреме/Крај - Исклучок ***
            // *** Полувреме/Крај со Двојни Шанси ***
            // *** Двојна Шанса за Пол./Крај ***
            // *** Двојна Шанса - Комбинации ***
            // *** Вкупно Голови - Исклучок ***
            // *** Вкупно Голови - Комбинации ***
            // *** ГГ/НГ - Комбинации ***
            // *** Тим 1 Голови - Опсег ***
            // *** Тим 1 Голови - Прво Полувреме ***
            // *** Тим 1 Голови - Второ Полувреме ***
            // *** Тим 1 Голови - Комбинации ***
            // *** Тим 2 Голови - Опсег ***
            // *** Тим 2 Голови - Прво Полувреме ***
            // *** Тим 2 Голови - Второ Полувреме ***
            // *** Тим 2 Голови - Комбинации ***
            // *** Било Кога ***
            // *** Двојна Победа ***
            // *** Двојна Победа - Комбинации ***
            // *** Сигурна Победа ***
            // *** Сигурна и Двојна Победа ***
            // *** Хендикеп ***
            // *** Хендикеп Полувреме ***
            // *** Без X ***
            // *** Без X - Полувреме ***
            // *** Прв Дава Гол ***
            // *** Паѓаат Повеќе голови ***
            // *** Паѓаат Повеќе Гол. - Комбинации ***
            // *** Време на Прв Гол ***
            // *** Време на Прв Гол - Комбинации ***
            // *** Пар/Непар ***
            // *** Точен Резултат ***
            // *** Точен Резултат - Полувреме ***
            // 1-X 2-X
           
            /*
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
                */
        }

        return $arr;
     }

    public function gamesData() {
        return [
            'konecenTip' => [
                '1' => 0,
                'x' => 0,
                '2' => 0,
            ],
            'poluvremeKraj' => [
                '11' => 0,
                '1x' => 0,
                '12' => 0,
                'x1' => 0,
                'xx' => 0,
                'x2' => 0,
                '21' => 0,
                '2x' => 0,
                '22' => 0
            ],
            'vkupnoGolovi' => [
                '01' => 0,
                '2+' => 0,
                '02' => 0,
                '3+' => 0,
                '03' => 0,
                '4+' => 0,
                '04' => 0,
                '5+' => 0,
                '6+' => 0,
                '7+' => 0,
            ],
            'dvataTimaDavaatGol' => [
                'gg' => 0,
                'ng' => 0,
                'ggpp' => 0,
                'ngpp' => 0,
                'ggvp' => 0,
                'ngvp' => 0,
                '2g2g' => 0,
            ],
            'tim1golovi' => [
                't10' => 0,
                't11+' => 0,
                't12+' => 0,
                't13+' => 0,
                't14+' => 0,
                't13g' => 0,
                't11>2' => 0,
                't12>1' => 0,
                't11=2' => 0,
            ],
            'tim2golovi' => [
                't20' => 0,
                't21+' => 0,
                't22+' => 0,
                't23+' => 0,
                't24+' => 0,
                't23g' => 0,
                't21>2' => 0,
                't22>1' => 0,
                't21=2' => 0,
            ],
            'prvoPoluvreme' => [
                '1p' => 0,
                'xp' => 0,
                '2p' => 0,
            ],
            'vtoroPoluvreme' => [
                '1p' => 0,
                'xp' => 0,
                '2p' => 0,
            ],
            'vkupnoGoloviOpseg' => [
                '12' => 0,
                '13' => 0,
                '14' => 0,
                '15' => 0,
                '16' => 0,
                '23' => 0,
                '24' => 0,
                '25' => 0,
                '26' => 0,
                '34' => 0,
                '35' => 0,
                '26' => 0,
                '45' => 0,
                '46' => 0,
            ],
            'vkupnoGoloviTocno' => [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
            ],
            'vkupnoGoloviPP' => [
                '0' => 0,
                '1+' => 0,
                '2+' => 0,
                '3+' => 0,
                '4+' => 0,
                '1' => 0,
                '2' => 0,
            ],
            'vkupnoGoloviPPopseg' => [
                '01' => 0,
                '02' => 0,
                '12' => 0,
                '23' => 0,
                '24' => 0,
                '13' => 0,
            ],
            'vkupnoGoloviPPisklucok' => [
                'ne1' => 0,
                'ne2' => 0,
            ]
        ];
    }
}
