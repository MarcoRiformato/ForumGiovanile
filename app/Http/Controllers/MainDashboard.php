<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\HomeContent;
use Inertia\Inertia;

use Illuminate\Http\Request;

class MainDashboard extends Controller
{
    public function index()
    {
        $latestArticles = Article::with(['media', 'user'])->orderBy('created_at', 'desc')->take(2)->get();
        $homepage = HomeContent::first();

        return Inertia::render('Dashboard', [
            'latestArticles' => $latestArticles,
            'homepage' => $homepage
        ]);
    }
}
