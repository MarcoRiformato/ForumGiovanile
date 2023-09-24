<?php

namespace Database\Factories;
use App\Models\Document;
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
         return [];
     } 

    public function run()
    {
        Document::factory()
            ->count(8)
            ->sequence(
                [
                    'title' => 'Istituzione Commissione di Garanzia',
                    'description' => 'Atto di istituzione della Commissione di Garanzia, successivamente meglio normata nel Regolamento. Il componente Costanza Lupi è stato sostituito con Fernando Falcone',
                    'link' => 'https://drive.google.com/file/d/1AyjA2JbcbePghsiTnkHFt9qUbQj6UUsi/view',
                ],
                [
                    'title' => 'Comitato di Coordinamento Rappresentanti degli Studenti Superiori elbani',
                    'description' => 'Delibera di istituzione del Comitato di Coordinamento dei rappresentanti degli studenti degli istituti superiori elbani',
                    'link' => 'https://drive.google.com/file/d/1AwhwKL7Fq5bqsipkVpZPnztpKSIuVjA2/view?usp=drivesdk',
                ],
                [
                    'title' => 'Esito elezioni 2022-25',
                    'description' => "Esito delle elezioni per l'Assemblea Plenaria del Forum Giovanile dell’Elba",
                    'link' => 'https://drive.google.com/file/d/1AvSKyMe2zgGw43jn82nGaNxgAlHQAMw9/view?usp=drivesdk',
                ],
                [
                    'title' => 'Verbale insediamento Forum',
                    'description' => "Verbale di insediamento dell'Assemblea Plenaria",
                    'link' => 'https://drive.google.com/file/d/1AaoWs4oeZWyKNAITpnCYy5Aym8-Jzz1y/view?usp=drivesdk',
                ],
                [
                    'title' => 'Statuto del Forum',
                    'description' => "Statuto del Forum Giovanile Intercomunale dell’Elba approvato dai comuni",
                    'link' => 'https://drive.google.com/file/d/1AQ6igSz1lXEzXjnImDa4fE6LfY202yWl/view',
                ],
                [
                    'title' => 'Regolamento del Forum',
                    'description' => "Regolamento del Forum Giovanile dell’Elba",
                    'link' => 'https://drive.google.com/file/d/1AUDvMN_6Dgb4Q6e_mYJweVuirM55wgiZ/view?usp=drivesdk',
                ],
                [
                    'title' => 'Regolamento Elettorale Forum',
                    'description' => "Regolamento elettorale del Forum Giovanile dell’Elba",
                    'link' => 'https://drive.google.com/file/d/1AXHJW7tnwI2jalJZMhJDVsLk5kPG5kCc/view?usp=drivesdk',
                ],
                [
                    'title' => 'Regolamento voto online',
                    'description' => "Integrazione al regolamento elettorale per voto online",
                    'link' => 'https://drive.google.com/file/d/1AY_iRmrJTWggu20bcHm4Xmg-n_rbm8Ob/view?usp=drivesdk',
                ]
            )
            ->create();
    }
}
