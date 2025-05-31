<?php

use App\Http\Controllers\LandingController;
//use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToiletController;
use App\Http\Controllers\ToiletReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;


Route::get('/', [LandingController::class, 'index'])->name('landing');
// atau
Route::get('/', [LandingController::class, 'index'])->name('app');

//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [AuthController::class, 'login'])->name('login.post');
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporans', [AdminController::class, 'laporans'])->name('laporans');
    Route::put('/laporans/{laporan}', [AdminController::class, 'updateLaporan'])->name('laporans.update');
    Route::get('/toilets', [AdminController::class, 'toilets'])->name('toilets');
    Route::get('/toilets/create', [AdminController::class, 'createToilet'])->name('toilets.create');
    Route::post('/toilets', [AdminController::class, 'storeToilet'])->name('toilets.store');
    Route::get('/toilets/{toilet}/edit', [AdminController::class, 'editToilet'])->name('toilets.edit');
    Route::put('/toilets/{toilet}', [AdminController::class, 'updateToilet'])->name('toilets.update');
    Route::delete('/toilets/{toilet}', [AdminController::class, 'destroyToilet'])->name('toilets.destroy');
    
});

Route::get('/app', function () {
    return view('app');
});

Route::get('/signin', function () {
    return view('signin');
})->name('signin');

Route::get('/signup', function () {
    return view('login'); // atau 'signup' jika file Anda sudah diganti namanya
})->name('signup');

Route::get('/submit', function () {
    return view('submit');
})->name('submit');

Route::post('/submit', [ToiletController::class, 'store'])->name('toilet.store');
Route::get('/toilets/{id}/reviews', [ToiletReviewController::class, 'show'])->name('toilet.review.show');
//Route::post('/toilets/{id}/reviews', [ToiletReviewController::class, 'store'])->name('toilet.review.store');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/about', [\App\Http\Controllers\AboutController::class, 'index'])->name('about');
Route::get('/reviews', function () {
    return view('review');
})->name('review.index');


Route::get('/reviews', [UserReviewController::class, 'index'])->name('user.reviews');
Route::middleware(['auth'])->group(function () {
    Route::post('/laporan', [UserReviewController::class, 'store'])->name('laporan.store');
});

//Route::get('/reviews', [UserReviewController::class, 'index'])->name('user.reviews');
//Route::post('/reviews', [UserReviewController::class, 'store'])->name('reviews.store');

Route::get('/findtoilet', [LandingController::class, 'findToilet'])->name('findtoilet');
Route::get('/findtoilet/all', [LandingController::class, 'findToiletAll'])->name('findtoilet.all');

//Route::get('/reports', [ReportController::class, 'index'])->name('report');
//Route::get('/reports/{id}', [ReportController::class, 'show'])->name('report.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/toilet/{toilet}/review', [ToiletReviewController::class, 'store'])->name('toilet.review.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/{toilet}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});