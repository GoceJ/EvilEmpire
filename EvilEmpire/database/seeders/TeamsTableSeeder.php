<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = \Faker\Factory::create();
        //     Team::insert([
        //         [
        //             'name' => 'Title K',
        //         ],
        //         [
        //             'name' => 'Title 2K',
        //         ]]
        //     );
        $json = file_get_contents("./dddd.json");
        $teams = json_decode($json);
  
        foreach ($teams as $value) {
            Team::create([
                "name" => $value->team1->name
            ]);
            Team::create([
                "name" => $value->team2->name
            ]);
        }
    }
}
