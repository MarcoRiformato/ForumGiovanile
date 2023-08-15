<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainDashboard;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::resource('/articles', ArticleController::class);
Route::get('documents/index', [DocumentController::class, 'index'])->name('documents.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Articles routes
    Route::get('/admin/articles/{article}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::get('/admin/articles/create', [ArticleController::class, 'edit'])->name('admin.articles.create');
    Route::post('/admin/articles/{article}/media', [MediaController::class, 'store'])->name('admin.articles.media.store');

    // Users routes
    Route::resource('/admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'edit' => 'admin.users.edit',
    ]);

    // Documents routes
    Route::get('/admin/documents.index', [AdminController::class, 'manageDocuments'])->name('admin.documents.index');

    // Documents routes
    Route::get('/admin/documents/{document}/edit', [DocumentController::class, 'edit'])->name('admin.documents.edit');
    Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('admin.documents.create');
    Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('admin.documents.store');
    Route::put('/admin/documents/{document}', [DocumentController::class, 'update'])->name('admin.documents.update');
    Route::delete('/admin/documents/{document}', [DocumentController::class, 'destroy'])->name('admin.documents.destroy');

    
});

Route::get('/dashboard', [MainDashboard::class, 'index'])->name('dashboard');


