<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Team;
use App\Models\Point;
use App\Models\League;
use App\Models\Unique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents( __DIR__ . "../../../database/data/teams.json");
        $jsonFormat = '[' . $json . ']';
        $teams = json_decode($jsonFormat);    

        foreach ($teams as $value) {
            try {
                $unique = sha1(json_encode($value));
                
                if (Unique::where('hash_identify', $unique)->exists()) {
                    continue;
                } else {
                    Unique::firstOrCreate([
                        "hash_identify" => $unique
                    ]);

                    Team::firstOrCreate([
                        "name" => $value->team1->name
                    ]);
                    $team1Id = Team::where('name', $value->team1->name)->first()->id;

                    Team::firstOrCreate([
                        "name" => $value->team2->name
                    ]);
                    $team2Id = Team::where('name', $value->team2->name)->first()->id;

                    $points = new Point();
                    $points->t1_coef = $value->team1->coef;
                    $points->t2_coef = $value->team2->coef;
                    $points->t1_q1 = $value->team1->q1;
                    $points->t1_q2 = $value->team1->q2;
                    $points->t1_q3 = $value->team1->q3;
                    $points->t1_q4 = $value->team1->q4;
                    $points->t2_q1 = $value->team2->q1;
                    $points->t2_q2 = $value->team1->q1;
                    $points->t2_q3 = $value->team1->q1;
                    $points->t2_q4 = $value->team1->q1;
                    $points->save();
                    $pointsId = $points->id;

                    $league = League::where('name', $value->league);
                    if ($league->exists()) {
                        $leagueId = $league->first()->id;
                    } else {
                        $leagueObj = new League();
                        $leagueObj->name = $value->league;
                        $leagueId = League::insertGetId([
                            'name' => $value->league
                        ]);
                    }

                    Game::insert([
                        't1_id' => $team1Id,
                        't2_id' => $team2Id,
                        'points_id' => $pointsId,
                        'league_id' => $leagueId,
                        'home_team' => $team1Id,
                        'match_date' => $value->match_date
                    ]);
                }
            } catch (\Throwable $th) {
                file_put_contents('./database/data/logs/teams_error.txt', PHP_EOL . '~~~' .  now() . "~~~" . PHP_EOL . $th->getMessage() . PHP_EOL . json_encode($value) . PHP_EOL, FILE_APPEND);
            }
        }

        file_put_contents('./database/data/seeded_data/teams.json', $json . ',', FILE_APPEND);
        // file_put_contents('./database/data/teams.json', '');
        file_put_contents('./database/data/logs/teams_seeded.txt', now() . PHP_EOL, FILE_APPEND);
    }
}