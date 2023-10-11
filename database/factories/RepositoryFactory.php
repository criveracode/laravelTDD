<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class RepositoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),//El repositorio que se creara pertenecera a un usuario definiendo su id:('user_id' => User::factory()) 
            'url' => $this->faker->url,
            'description' => $this->faker->text
        ];
    }
}
