<?php

namespace Database\Seeders;
use App\Models\Campaign;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'prova',
            'email' => 'prova@gmail.com',
            'password' => Hash::make('123456789')
        ]);

        Campaign::factory()->count(4)->create();
        Article::factory()->count(4)->create();
    }
}
