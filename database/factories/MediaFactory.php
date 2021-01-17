<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Category;
use App\Models\MediaType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'user_id' => User::factory(),
          'name' => $this->faker->name('male'),
          'description' => $this->faker->text(400),
          'slug' => $this->faker->slug(),
          'price' => $this->faker->numberBetween(0, 20000),
          'file' => $this->faker->image(),
          'dimension' => $this->faker->numberBetween(100, 400) . 'x' . $this->faker->numberBetween(100, 400),
          'size' => $this->faker->numberBetween(1500, 200000),
          'likes' => $this->faker->numberBetween(0, 200),
          'views' => $this->faker->numberBetween(0, 10000),
          'downloads' => $this->faker->numberBetween(0, 10000),
          'category_id' => $this->faker->numberBetween(1, count(Category::all())),
          'user_id' => $this->faker->numberBetween(1, count(User::all())),
          'access_id' => $this->faker->numberBetween(1, 2),
          'published' => $this->faker->boolean(),
          'media_type_id' => 1,
          'media_format_id' => $this->faker->numberBetween(1, count(MediaType::all())),
          'description' => $this->faker->text(200),
        ];
    }
}
