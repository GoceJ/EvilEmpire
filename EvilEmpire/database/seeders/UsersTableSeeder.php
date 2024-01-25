<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'email' => 'asd@asd',
            'email_verified_at' => now(),
            'password' => '$2y$10$5o8Evo6CLZf2niNmYcAu0u9G.mUH8qKcxitkGakSq7.8FdGH9QDLS',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
