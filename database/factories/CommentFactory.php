<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'media_id' => Media::factory(),
          'user_id' => User::factory(),
          'message' => $this->faker->paragraph
        ];
    }
}
