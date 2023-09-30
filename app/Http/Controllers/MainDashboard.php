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
        $articleIds = [5, 9]; 
        $latestArticles = Article::with(['media', 'user'])->whereIn('id', $articleIds)->get();
        $homepage = HomeContent::first();
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
