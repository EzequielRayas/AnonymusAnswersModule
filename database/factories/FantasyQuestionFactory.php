<?php

namespace Database\Factories;

use App\Models\FantasyQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FantasyQuestionFactory extends Factory
{
    protected $model = FantasyQuestion::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Relacionado a un usuario
            'question' => $this->faker->sentence(10),
            'start_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 week'),
        ];
    }
}

