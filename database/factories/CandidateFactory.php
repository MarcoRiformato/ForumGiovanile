<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidate;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    public function definition()
    {
        $candidates = [
            ['name' => 'Giorgiovanni Esposito', 'description' => 'Più Pilu per tutti'],
            ['name' => 'Arnaldo Bonomelli', 'description' => 'Votatemi per favore'],
        ];

        $candidate = $this->faker->randomElement($candidates);

        return [
            'question_id' => \App\Models\Question::factory(),
            'name' => $candidate['name'],
            'description' => $candidate['description'],
        ];
    }
}


