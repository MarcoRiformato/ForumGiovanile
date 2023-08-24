<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainDashboard;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ElectionController;

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
Route::get('elections/index', [ElectionController::class, 'index'])->name('elections.index');
Route::get('elections/{election}', [ElectionController::class, 'show'])->name('elections.show');

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
    Route::get('/admin/documents/{document}/edit', [DocumentController::class, 'edit'])->name('admin.documents.edit');
    Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('admin.documents.create');
    Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('admin.documents.store');
    Route::put('/admin/documents/{document}', [DocumentController::class, 'update'])->name('admin.documents.update');
    Route::delete('/admin/documents/{document}', [DocumentController::class, 'destroy'])->name('admin.documents.destroy');

    // Elections routes
    Route::get('/admin/elections/create', [ElectionController::class, 'createElectionDetails'])->name('admin.elections.create');
    Route::post('/admin/elections/create', [ElectionController::class, 'storeElectionDetails']);
    Route::get('/admin/elections/questions', [ElectionController::class, 'createQuestions'])->name('admin.elections.questions');
    Route::post('/admin/elections/questions/store', [ElectionController::class, 'storeQuestions'])->name('admin.elections.questions.store');
    Route::get('/admin/elections/review', [ElectionController::class, 'review'])->name('admin.elections.review');
    
    Route::get('/admin/elections/edit/{id}/step1', [ElectionController::class, 'editStep1'])->name('admin.elections.step1');
    Route::get('/admin/elections/edit/{id}/step2', [ElectionController::class, 'editStep2'])->name('admin.elections.step2');

    Route::put('/admin/elections/edit/{id}/step1', [ElectionController::class, 'updateStep1'])->name('admin.elections.updateStep1');
    Route::put('/admin/elections/edit/{id}/step2', [ElectionController::class, 'updateStep2'])->name('admin.elections.updateStep2');


    Route::get('/admin/elections.index', [AdminController::class, 'manageElections'])->name('admin.elections.index');
    Route::get('/admin/elections/{election}', [ElectionController::class, 'showForAdmin'])->name('admin.elections.show');
    Route::post('/admin/elections/store', [ElectionController::class, 'store'])->name('admin.elections.store');
    Route::delete('/admin/elections/{election}', [ElectionController::class, 'destroy'])->name('admin.elections.destroy');
    
    
});

Route::get('/dashboard', [MainDashboard::class, 'index'])->name('dashboard');


