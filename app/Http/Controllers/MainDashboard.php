<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Vision;
use App\Models\User;
use App\Models\HomeContent;
use Inertia\Inertia;

use Illuminate\Http\Request;

class MainDashboard extends Controller
{
    public function index()
    {
        $articleIds = [5, 21]; 
        $latestArticles = Article::with(['media', 'user'])->whereIn('id', $articleIds)->get();
        $homepage = HomeContent::first() ?? new HomeContent([
            'main_title' => 'Forum Giovanile Elba',
            'sub_title' => 'Benvenuti',
            'about_us' => 'Siamo un gruppo di giovani...',
            'latest_news_title' => 'Ultime Notizie',
            'latest_news_desc' => 'Scopri le ultime novità',
            'our_vision_title' => 'La nostra visione',
            'our_vision_desc' => 'Cosa vogliamo realizzare',
            'team_title' => 'Il nostro team',
            'team_desc' => 'Chi siamo'
        ]);
        $visions = Vision::all();
        $users = User::all();
    
        return Inertia::render('Dashboard', [
            'latestArticles' => $latestArticles,
            'homepage' => $homepage,
            'visions' => $visions,
            'users' => $users
        ]);
    }
    
}
