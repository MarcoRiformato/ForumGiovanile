<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $articles = Article::orderBy('created_at', 'desc')->get();

        return Inertia::render('IndexArticles', [
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CreateArticle');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'extract' => $request->extract,
            'body' => $request->body,
            'user_id' => auth()->id(), // add this line
        ]);
    
        return redirect()->route('admin.dashboard');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($article_id)
    {
        $article = Article::find($article_id);
        return Inertia::render('ShowArticle', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return Inertia::render('Admin/EditArticle', [
            'article' => $article
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article->update([
            'title' => $request->title,
            'extract' => $request->extract,
            'body' => $request->body
        ]);
    
        return redirect()->route('admin.dashboard')->with('message', 'Articolo modificata');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($article_id)
    {
        $article = Article::find($article_id);
        $article->delete();

        return redirect()->route('articles.index');
    }
}
