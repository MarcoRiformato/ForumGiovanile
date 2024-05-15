<?php

namespace Database\Seeders;
use App\Models\Campaign;
use App\Models\Article;
use App\Models\User;
use App\Models\Document;
use App\Models\Election;
use App\Models\Question;
use App\Models\Option;
use App\Models\Candidate;
use App\Models\HomeContent;
use App\Models\Jobs;
use App\Models\Worker;
use Database\Factories\VisionFactory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'prova',
            'email' => 'prova@gmail.com',
            'password' => Hash::make('123456789')
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.it',
            'password' => Hash::make('123456789'),
            'is_admin' => '1'
        ]);

        // Create one election
        $election = Election::factory()->create();

        // Create two questions with options
        for ($i = 0; $i < 2; $i++) {
            $question = Question::factory()->create([
                'election_id' => $election->id,
                'type' => 'options',
            ]);
            Option::factory()->count(4)->create(['question_id' => $question->id]);
        }

        // Create two questions with candidates
        for ($i = 0; $i < 2; $i++) {
            $question = Question::factory()->create([
                'election_id' => $election->id,
                'type' => 'candidates',
            ]);
            Candidate::factory()->count(4)->create(['question_id' => $question->id]);
        }

        $visionFactory = new VisionFactory();
        $visionFactory->presetVisions();

        Article::factory()->count(4)->create();
        HomeContent::factory()->create();
        Jobs::factory()->count(5)->create();
        Worker::factory()->count(5)->create();

        $documentFactory = new \Database\Factories\DocumentFactory();
        $documentFactory->run();
    }
}


