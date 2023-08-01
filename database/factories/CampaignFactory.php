<?php

namespace Database\Factories;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Zulia',
            'description' => 'Questa è una campagna',
            'testingCampaign' => false,
            'status' => true,
            'startingDate' => '2023-01-18',
            'endDate' => '2023-04-18',
        ];
    }
}
