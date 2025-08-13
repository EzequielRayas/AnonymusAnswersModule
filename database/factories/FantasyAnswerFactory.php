<?php

namespace Database\Factories;

use App\Models\FantasyAnswer;
use App\Models\FantasyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class FantasyAnswerFactory extends Factory
{
    protected $model = FantasyAnswer::class;

    public function definition()
    {
        return [
            'question_id' => FantasyQuestion::factory(), // Relacionado a una pregunta
            'answer' => $this->faker->paragraph(),
        ];
    }
}

