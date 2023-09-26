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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisionController;
use App\Http\Controllers\AdController;

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
Route::get('/', [MainDashboard::class, 'index'])->name('home');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [MainDashboard::class, 'index'])->name('dashboard');
Route::get('documenti/indice', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/vota', [ElectionController::class, 'index'])->name('elections.index');
Route::get('vota/{election}', [ElectionController::class, 'show'])->name('elections.show');
Route::get('visioni/{vision}', [VisionController::class, 'show'])->name('visions.show');

Route::post('election/{election}/vote', [ElectionController::class, 'storeVote'])->name('election.vote');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('admin/admindashboard', [AdminController::class, 'index'])->name('admin.admindashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    //Homepage routes
    Route::get('/admin/homepage.edit', [AdminController::class, 'manageHomepage'])->name('admin.homepage.edit');
    Route::put('/admin/homepages/{homepage}', [HomeController::class, 'update'])->name('admin.homepages.update');

    //Vision routes
    Route::get('/admin/visions.index', [VisionController::class, 'index'])->name('admin.visions.index');
    Route::get('/admin/visions/create', [VisionController::class, 'create'])->name('admin.visions.create');
    Route::post('/admin/visions/store', [VisionController::class, 'store'])->name('admin.visions.store');
    Route::get('/admin/visions/{vision}/edit', [VisionController::class, 'edit'])->name('admin.visions.edit');
    Route::put('/admin/visions/{vision}', [VisionController::class, 'update'])->name('admin.visions.update');

    //Ad routes
    Route::get('/admin/ads.index', [AdController::class, 'index'])->name('admin.ads.index');
    Route::get('/admin/ads/create', [AdController::class, 'create'])->name('admin.ads.create');
    Route::post('/admin/ads/store', [AdController::class, 'store'])->name('admin.ads.store');
    Route::get('/admin/ads/{ad}/edit', [AdController::class, 'edit'])->name('admin.ads.edit');
    Route::put('/admin/ads/{ad}', [AdController::class, 'update'])->name('admin.ads.update');
    Route::delete('/admin/ads/{ad}', [AdController::class, 'destroy'])->name('admin.ads.destroy');

    // Articles routes
    Route::get('/admin/articles/{article}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
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


;