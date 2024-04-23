<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Document;
use App\Models\Election;
use App\Models\HomeContent;
use App\Models\Jobs;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/AdminDashboard');
    }

    public function dashboard()
    {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->get();
    
        return Inertia::render('Admin/Dashboard', [
            'articles' => $articles
        ]);
    }
    

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function manageArticles()
    {
        $articles = Article::all();
        return view('admin.articles.index', compact('articles'));
    }

    public function manageDocuments()
    {
        $documents = Document::all();
        return Inertia::render('Admin/Documents/Index', compact('documents'));
    }

    public function manageElections()
    {
        $elections = Election::all();
        return Inertia::render('Admin/Elections/Index', compact('elections'));
    }

    public function manageHomepage()
    {
        $homepages = HomeContent::first();
        return Inertia::render('Admin/Homepage/Edit', compact('homepages'));
    }

    public function manageJobs()
    {
        $jobs = Jobs::all();
        return Inertia::render('Admin/Jobs/Index', compact('jobs'));
    }
    
}
