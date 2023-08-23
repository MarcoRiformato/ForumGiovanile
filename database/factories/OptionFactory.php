<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Option;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition()
    {
        $texts = ['Boia deh si', 'No dai bimbi no']; 
        return [
            'question_id' => \App\Models\Question::factory(),
            'text' => $this->faker->randomElement($texts), 
        ];
    }
}


