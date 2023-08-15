<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Document;
use Inertia\Inertia;

class AdminController extends Controller
{
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
    
}
