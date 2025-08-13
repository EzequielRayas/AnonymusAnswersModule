<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FantasyQuestion;
use App\Models\FantasyAnswer;
use Illuminate\Database\Seeder;

class FantasyQuestionSeeder extends Seeder
{
    public function run()
    {
        FantasyQuestion::factory(3)
            ->has(FantasyAnswer::factory(5), 'answers') // Crea 5 respuestas por pregunta
            ->create();
    }
}
