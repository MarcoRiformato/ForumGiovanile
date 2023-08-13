<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
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

    // Additional CRUD methods for users, articles, etc.
}
