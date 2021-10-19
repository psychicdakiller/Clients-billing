<?php

namespace Database\Factories;

use App\Models\AddOn;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddOnFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AddOn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
