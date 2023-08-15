<?php

namespace Database\Seeders;
use App\Models\Campaign;
use App\Models\Article;
use App\Models\User;
use App\Models\Document;
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
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.it',
            'password' => Hash::make('123456789'),
            'is_admin' => '1'
        ]);

        Campaign::factory()->count(4)->create();
        Article::factory()->count(4)->create();
        Document::factory()->count(4)->create();
    }
}
