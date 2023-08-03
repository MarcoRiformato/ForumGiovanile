<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Titolo della notizia',
            'extract' => 'Scopri le ultime novità',
            'body' => 'Il testo della notizia, quello lungo',
            'user_id' => User::pluck('id')->random(),
        ];
    }
}
