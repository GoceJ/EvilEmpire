<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(20)->create();
        $this->call([
            // UsersTableSeeder::class,
            BasketballPlayersTableSeeder::class,
            BasketballTeamsTableSeeder::class,
            FootballTableSeeder::class
        ]);
    }
}
