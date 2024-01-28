<?php

namespace Database\Seeders;

use App\Models\FootballGame;
use App\Models\FootballLeague;
use App\Models\FootballPoint;
use App\Models\FootballTeam;
use App\Models\Unique;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FootballTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents( __DIR__ . "../../../database/data/football_teams.json");
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

                    FootballTeam::firstOrCreate([
                        "name" => $value->team1->name
                    ]);
                    $team1Id = FootballTeam::where('name', $value->team1->name)->first()->id;

                    FootballTeam::firstOrCreate([
                        "name" => $value->team2->name
                    ]);
                    $team2Id = FootballTeam::where('name', $value->team2->name)->first()->id;

                    $points = new FootballPoint();
                    $points->t1_coef = $value->team1->coef;
                    $points->xcoef = $value->xcoef;
                    $points->t2_coef = $value->team2->coef;
                    $points->t1_1half = $value->team1->half_time;
                    $points->t1_total = $value->team1->total;
                    $points->t2_1half = $value->team2->half_time;
                    $points->t2_total = $value->team2->total;
                    $points->save();
                    $pointsId = $points->id;

                    $league = FootballLeague::where('name', $value->league);
                    if ($league->exists()) {
                        $leagueId = $league->first()->id;
                    } else {
                        $leagueId = FootballLeague::insertGetId([
                            'name' => $value->league
                        ]);
                    }

                    FootballGame::insert([
                        't1_id' => $team1Id,
                        't2_id' => $team2Id,
                        'points_id' => $pointsId,
                        'league_id' => $leagueId,
                        'home_team' => $team1Id,
                        'match_date' => $value->match_date
                    ]);
                }
            } catch (\Throwable $th) {
                file_put_contents(__DIR__ . '/../data/logs/football_teams_error.txt', PHP_EOL . '~~~' .  now() . "~~~" . PHP_EOL . $th->getMessage() . PHP_EOL . json_encode($value) . PHP_EOL, FILE_APPEND);
            }
        }

        file_put_contents(__DIR__ . '/../data/seeded_data/football_teams.json', $json . ',', FILE_APPEND);
        file_put_contents(__DIR__ . '/../data/football_teams.json', '');
        file_put_contents(__DIR__ . '/../data/logs/football_teams_seeded.txt', now() . PHP_EOL, FILE_APPEND);
    }
}
