<?php

namespace Database\Seeders;

use App\Models\FantasyQuestion; // Importa el modelo FantasyQuestion
use App\Models\User;           // Necesitamos el modelo User para asignar user_id
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;              // Para trabajar fácilmente con fechas

class FantasyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que exista al menos un usuario para poder asignar el user_id.
        // Si no tienes usuarios, puedes crear uno aquí o en un UserSeeder aparte.
        $user = User::first(); // Obtiene el primer usuario existente
        
        // Si no hay usuarios, puedes crear uno temporalmente (solo para el seeder)
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Seeder User',
                'email' => 'seeder@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_admin' => true, // O false, según lo necesites
            ]);
        }

        // Creamos una nueva pregunta fantasy
        FantasyQuestion::create([
            'user_id' => $user->id, // Asignamos la pregunta a un usuario existente
            'question' => '¿Quién ganará el campeonato mundial de la Liga Fantasy de este año?',
            'status' => true, // Activa (true) o inactiva (false)
            'start_date' => Carbon::parse('2025-07-01'), // Fecha de inicio de la pregunta
            'end_date' => Carbon::parse('2025-12-31'),   // Fecha de fin de la pregunta
            'placeholder' => 'Escribe tu predicción aquí...', // Texto de marcador de posición
        ]);

        // Puedes añadir más preguntas aquí
        FantasyQuestion::create([
            'user_id' => $user->id,
            'question' => '¿Cuál será la mayor sorpresa de la temporada?',
            'status' => false, // Pregunta inactiva
            'start_date' => Carbon::parse('2025-08-15'),
            'end_date' => Carbon::parse('2025-11-30'),
            'placeholder' => '¡Sorpréndenos con tu idea!',
        ]);

        // Si necesitas crear muchas preguntas, puedes usar un factory
        // FantasyQuestion::factory()->count(5)->create(['user_id' => $user->id]);
    }
}
