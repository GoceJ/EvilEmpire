<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for ($i=0; $i < 50 ; $i++) { 
            $post = new Post();
            $post->title = 'Post Title ' . $i; 
            $post->desc = 'Description for post ' . $i;
            $post->save();
        }
    }
}
