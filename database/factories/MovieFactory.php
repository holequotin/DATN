<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $trailer_rand = ['DotnJ7tTA34', 'Mmq_NVwLN_g', 'D7eFpRf4tac', 'L5PW5r3pEOg', 'b391hapRbL4', 'GG30xtrBidQ', 'oHDi01Yn4tY', 'Zi88i4CpHe4'];
        return [
            'name' => $this->faker->name(),
            'director' => $this->faker->name().' '.strval(rand(0,1000)),
            'actor' => $this->faker->name(),
            'language' => $this->faker->locale(),
            'length' => rand(100,200),
            'release_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'trailer' => $trailer_rand[rand(0,count($trailer_rand)-1)],
            'description' => $this->faker->text(500),
            'rating_id' => rand(1,Role::all()->count()),
        ];
    }
}
