<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {        
        $fakerFileName = $this->faker->image(
            storage_path("app/public/image/movies"),
            800,
            600
        );

        return [
            'path' => "image/movies/" . basename($fakerFileName),
        ];
    }
}
