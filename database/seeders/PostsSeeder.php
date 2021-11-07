<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create(['title' => 'Titulo 1', 'slug' => 'titulo-1', 'user_id' =>User::inRandomOrder()->first()->id]);
        Post::create(['title' => 'Titulo 2', 'slug' => 'titulo-2', 'user_id' =>User::inRandomOrder()->first()->id]);
    }
}
