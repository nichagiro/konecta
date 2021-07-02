<?php

namespace Database\Factories;

use App\Models\client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "document" => $this->faker->numerify('##########'),
            "email" => $this->faker->freeEmail,
            "direccion" => $this->faker->address
        ];
    }
}
