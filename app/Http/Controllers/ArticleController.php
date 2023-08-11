<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Media;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('media')->orderBy('created_at', 'desc')->get();
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
/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'extract' => 'required|string|max:1000',
        'body' => 'required|string',
        'media_file' => 'sometimes|file|mimes:jpg,jpeg,png,gif,webp,mp4,mp3,pdf|max:10240', // max 10MB
    ]);

    $article = Article::create([
        'title' => $validatedData['title'],
        'extract' => $validatedData['extract'],
        'body' => $validatedData['body'],
        'user_id' => auth()->id(),
    ]);

    if ($request->hasFile('media_file')) {
        $file = $request->file('media_file');
        $path = $file->store('media', 'public');

        $media = new Media([
            'filepath' => $path,
            'filetype' => $this->determineFileType($file->getClientMimeType()),
            'filename' => $file->getClientOriginalName(),
            'article_id' => $article->id,
        ]);            
                   

        $media->save();
        $article->media()->attach($media);
    }

    return redirect()->route('admin.dashboard');
}

    
    private function determineFileType($mimeType) {
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
            return 'image';
        } elseif (in_array($mimeType, ['video/mp4'])) {
            return 'video';
        } else {
            return 'document';
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($article_id)
    {
        $article = Article::with('media')->find($article_id); // This will eager load the associated media with the article
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
