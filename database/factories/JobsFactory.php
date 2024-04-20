<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Jobs; // Replace with the appropriate namespace if different

class JobsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $jobTitles = ['Cameriere', 'Addetto/a di segreteria', 'Sviluppatore Web'];
        $companies = ['Ristorante Il Garibaldino', 'Rosselba le Palme', 'Infoelba'];
        $locations = ['Capoliveri', 'Portoferraio', 'Marina di Campo'];
        $salaryRanges = ['1400-1600', '1200-1400', '1600-1800'];
        $shortDescriptions = [
            'Cerchiamo ragazzo/a per ruolo di cameriere, preferibilmente con esperienza. Non disponiamo di alloggio. Turno serale e festivo.',
            'Cerchiamo giovani dinamici per diversi ruoli in cucina. Anche prime esperienza, possibilità di alloggio.',
            'Cercasi fattorino (Urgente) disponibile a cominciare da subito, turno notturno'
        ];
        $imageUrls = [
            'https://tailwindui.com/img/logos/48x48/tuple.svg',
            'https://tailwindui.com/img/logos/48x48/savvycal.svg',
            'https://tailwindui.com/img/logos/48x48/reform.svg'
        ];

        return [
            'lavoro' => $this->faker->randomElement($jobTitles),
            'imageUrl' => $this->faker->randomElement($imageUrls),
            'azienda' => $this->faker->randomElement($companies),
            'luogo' => $this->faker->randomElement($locations),
            'stipendio' => $this->faker->randomElement($salaryRanges),
            'descrizione' => $this->faker->randomElement($shortDescriptions),
            'data_pubblicazione' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Indicate which model this factory is for.
     *
     * @return string
     */
    protected $model = Jobs::class; // Make sure this is the correct class for your Jobs model
}