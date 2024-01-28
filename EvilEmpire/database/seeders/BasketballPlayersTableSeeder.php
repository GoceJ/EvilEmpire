<?php

namespace Database\Seeders;

use App\Models\BasketballTeam;
use App\Models\BasketballScore;
use App\Models\BasketballLeague;
use App\Models\BasketballPlayer;
use App\Models\BasketballPlayerGame;
use App\Models\Unique;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BasketballPlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents( __DIR__ . "../../../database/data/basketball_players.json");
        $jsonFormat = '[' . $json . ']';
        $players = json_decode($jsonFormat);    

        foreach ($players as $value) {
            try {
                $unique = sha1(json_encode($value));
                
                if (Unique::where('hash_identify', $unique)->exists()) {
                    continue;
                } else {
                    Unique::firstOrCreate([
                        "hash_identify" => $unique
                    ]);

                    BasketballPlayer::firstOrCreate([
                        "name" => $value->player
                    ]);
                    $playerId = BasketballPlayer::where('name', $value->player)->first()->id;

                    BasketballTeam::firstOrCreate([
                        "name" => $value->team
                    ]);
                    $teamId = BasketballTeam::where('name', $value->team)->first()->id;

                    $score = new BasketballScore();
                    $score->score_points = $value->points;
                    $score->save();
                    $scoreId = $score->id;

                    $league = BasketballLeague::where('name', $value->league);
                    if ($league->exists()) {
                        $leagueId = $league->first()->id;
                    } else {
                        $leagueId = BasketballLeague::insertGetId([
                            'name' => $value->league
                        ]);
                    }

                    BasketballPlayerGame::insert([
                        'league_id' => $leagueId,
                        'player_id' => $playerId,
                        'team_id' => $teamId,
                        'score_id' => $scoreId,
                        'match_date' => $value->match_date
                    ]);
                }
            } catch (\Throwable $th) {
                file_put_contents(__DIR__ . '/../data/logs/basketball_players_error.txt', PHP_EOL . '~~~' .  now() . "~~~" . PHP_EOL . $th->getMessage() . PHP_EOL . json_encode($value) . PHP_EOL, FILE_APPEND);
            }
        }

        file_put_contents(__DIR__ . '/../data/seeded_data/basketball_players.json', $json . ',', FILE_APPEND);
        file_put_contents(__DIR__ . '/../data/basketball_players.json', '');
        file_put_contents(__DIR__ . '/../data/logs/basketball_players_seeded.txt', now() . PHP_EOL, FILE_APPEND);
    }
}
