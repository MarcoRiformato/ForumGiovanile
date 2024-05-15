<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people'),
            'contract_type' => $this->faker->randomElement(['Tempo pieno', 'Part time', 'Collaborazione a partita IVA']),
            'job_titles' => $this->faker->randomElement(['Bagnino', 'Cameriere', 'Cuoco', 'Architetto', 'Sviluppatore web']),
            'description' => $this->faker->text(200),
            'residence' => $this->faker->city() . ', Elba',
            'availability' => $this->faker->date(),
            'has_car' => $this->faker->boolean(50),
            'work_experience' => $this->faker->sentence(10),
            'languages' => 'Italiano',
            'has_hccp_certificate' => $this->faker->boolean(30),
            'education' => $this->faker->randomElement(['Diploma scuola superiore', 'Laurea', 'Magistrale'])
        ];
    }

}
