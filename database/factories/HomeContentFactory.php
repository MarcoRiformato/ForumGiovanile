<?php

namespace Database\Factories;

use App\Models\HomeContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HomeContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'main_title' => 'Siamo il forum giovanile elbano',
            'sub_title' => 'Rappresentiamo tutti gli elbani dai 13 ai 26 anni',
            'about_us' => 'Il Forum Giovanile dell’Elba è un organo ufficiale, istituito dai 7 comuni ed eletto ogni tre anni da tutti i ragazzi elbani tra i 13 e i 26 anni. Il Forum rappresenta tutti i giovani con i comuni, la Provincia e le altre istituzioni locali e nazionali, per realizzare le richieste e le idee della comunità giovanile. Inoltre organizziamo feste ed eventi per rendere più attiva la vita sociale della nostra isola.',
            
            'latest_news_title' => 'Ultime notizie',
            'latest_news_desc' => 'Leggi analisi, sondaggi e notizie del Forum Giovanile Elbano',

            'our_vision_title' => 'La nostra visione',
            'our_vision_desc' => 'I temi a cui lavoriamo più attivamente sono:',

            'team_title' => 'Our team',
            'team_desc' => 'Sit facilis neque ab nulla vel. Cum eos in laudantium. Temporibus eos totam in dolorum. Nemo vel facere repellendus ut eos dolores similique.'
        ];
    }
}
