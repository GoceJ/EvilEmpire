<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Score;
use App\Models\League;
use App\Models\Player;
use App\Models\PlayerGame;
use App\Models\Unique;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents( __DIR__ . "../../../database/data/players.json");
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

                    Player::firstOrCreate([
                        "name" => $value->player
                    ]);
                    $playerId = Player::where('name', $value->player)->first()->id;

                    Team::firstOrCreate([
                        "name" => $value->team
                    ]);
                    $teamId = Team::where('name', $value->team)->first()->id;

                    $score = new Score();
                    $score->score_points = $value->points;
                    $score->save();
                    $scoreId = $score->id;

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

                    PlayerGame::insert([
                        'league_id' => $leagueId,
                        'player_id' => $playerId,
                        'team_id' => $teamId,
                        'score_id' => $scoreId,
                        'match_date' => $value->match_date
                    ]);
                }
            } catch (\Throwable $th) {
                file_put_contents('./database/data/logs/players_error.txt', PHP_EOL . '~~~' .  now() . "~~~" . PHP_EOL . $th->getMessage() . PHP_EOL . json_encode($value) . PHP_EOL, FILE_APPEND);
            }
        }

        file_put_contents('./database/data/seeded_data/players.json', $json . ',', FILE_APPEND);
        // file_put_contents('./database/data/players.json', '');
        file_put_contents('./database/data/logs/players_seeded.txt', now() . PHP_EOL, FILE_APPEND);
    }
}
