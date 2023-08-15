<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Statuto del forum',
            'description' => 'Questo è un documento',
            'link' => 'https://docs.google.com/document/d/1AtBB7fap8ilM3e-ae0-3rk0NE9vPe2YoPtLkuTVvlaM/edit?usp=sharing'
        ];
    }
}
