<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\MediaTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MediaTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'media_id' => $this->faker->numberBetween(1, count(Media::all())),
          'tag_id' => $this->faker->numberBetween(1, count(Tag::all())),
        ];
    }
}
