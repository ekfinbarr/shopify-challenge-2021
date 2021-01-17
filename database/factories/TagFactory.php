<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      $label = $this->faker->country . ' ' . $this->faker->state . uniqid();
        return [
          'name' => Str::slug(Str::lower($label)),
          'label' => $label
        ];
    }
}
