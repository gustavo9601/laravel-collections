<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = $this->faker->title . ' ' . $this->faker->word . $this->faker->randomAscii();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
