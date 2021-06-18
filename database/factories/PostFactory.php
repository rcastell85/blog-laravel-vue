<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(20),
            'content' => $this->faker->text(2000),
            'status' => $this->faker->randomElement([Post::BORRADOR, Post::PUBLICADO, Post::INACTIVO]),
            'user_id' => User::all()->random()->id
        ];
    }
}
