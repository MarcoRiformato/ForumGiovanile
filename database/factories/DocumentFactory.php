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
            'embed_link' => '<iframe src="https://docs.google.com/document/d/e/2PACX-1vQO9PCMf8JbnizMmiTY8rBKAZY2p9u6lXtxg9OTnx0Pk0OQ_aIT7xBoRZG0aE8cgf9kFzVILDwTNJ8U/pub?embedded=true"></iframe>'
        ];
    }
}
