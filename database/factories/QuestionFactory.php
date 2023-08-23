<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        $texts = [
            'Pisa merda?',
            'Te pesca o limone',
            'Rifo è un grande',
            'Spiaggia di sassi o sabbia?',
        ];

        return [
            'election_id' => \App\Models\Election::factory(),
            'text' => $this->faker->randomElement($texts),
            'type' => $this->faker->randomElement(['candidates', 'options']),
        ];
    }
}


