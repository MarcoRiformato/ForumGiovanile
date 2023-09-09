<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vision;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vision>
 */
class VisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vision::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }

    /**
     * Define preset visions.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function presetVisions()
    {
        $values = [
            [
                'title' => 'Diritto allo studio.',
                'desc' => 'Sia per le superiori che per le università',
                'icon' => 'AcademicCapIcon',
            ],
            [
                'title' => 'Trasporto pubblico.',
                'desc' => 'Il diritto a muoversi facilmente, in ogni periodo dell anno e momento della giornata',
                'icon' => 'GlobeEuropeAfricaIcon',
            ],
            [
                'title' => 'Educazione civica.',
                'desc' => 'Sensibilizzazione sull educazione civica, relazionale e sessuale',
                'icon' => 'BuildingLibraryIcon',
            ],
            [
                'title' => 'Eventi.',
                'desc' => 'Promozione di eventi ed iniziative per i giovani elbani',
                'icon' => 'UserGroupIcon',
            ]
        ];

        foreach ($values as $value) {
            Vision::create($value);
        }
    }
}
