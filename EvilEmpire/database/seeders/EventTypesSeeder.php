<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = ['Настан', 'Состаноци', 'Упис на факултет', 'Студентски културни настани'];

        foreach ($eventTypes as $eventType) {
            EventType::create(
                [
                    'type' => $eventType,
                ]
            );
        }
    }
}
