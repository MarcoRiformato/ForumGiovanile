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
            'title' => 'SATELLITI STARLINK DI ELON MUSK VISIBILE ANCHE NEI CIELI ELBANI',
            'extract' => 'Una fila di luci in movimento nel cielo. Un fenomeno immortalato ieri sera, 11 agosto, intorno alle 22 da diversi cittadini anche all isola d Elba.',
            'body' => 'Non si tratta di oggetti volanti non identificati, ma della costellazione di satelliti Starlink di Elon Musk per l’accesso a Internet globale a banda larga.
            Il loro obiettivo, infatti, è quello di portare internet anche nelle zone di guerra o nelle zone colpite da cataclismi climatici.
            
             
            
            I satelliti sono stati avvistati in tutto il Nord Italia, compreso il nostro scoglio, come previsto da alcuni siti specializzati.
            
             
            
            Intorno alla terra orbitano già circa 1.900 satelliti Stalink.
            
             
            
            Gli oggetti visibili nei giorni scorsi sono stati 53, sembrava un treno luminoso con tanti vagoni, da vero suggestivo per chi a quell ora era rivolto con lo sguardo in alto, oggetto del lancio partito dalla base di Cape Canaveral in Florida e compiuto con successo.
            Dopo la separazione del modulo con i satelliti, il razzo è tornato sulla Terra e atterrato sulla nave «A shortfall of Gravitas» nell Oceano Atlantico.',
            'user_id' => User::pluck('id')->random(),
        ];
    }
}
