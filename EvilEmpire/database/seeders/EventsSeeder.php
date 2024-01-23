<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 5; $i++) {
            Event::create(
                [
                    'title' => 'Title ' . $i,
                    // 'content' => 'Random text as content' . $i,
                    // 'image' => '/images/events/1.png',
                    'start_date' => $faker->dateTimeBetween('2022-01-25', '2022-01-30'),
                    'end_date' => $faker->dateTimeBetween('2022-02-01', '2022-02-05'),
                    'event_type_id' => rand(1, 4),
                ]
            );
        }
    }
}
