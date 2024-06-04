<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubscriptionController;

// Ruta raíz
Route::get('/', function () {
    return redirect()->route('videos.index');
});

// Rutas de autenticación
Auth::routes();

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profiles/search', [ProfileController::class, 'search'])->name('profiles.search');

    // Rutas para Videos
    Route::resource('videos', VideoController::class);

    // Rutas para Suscripciones
    Route::post('/subscribe/{id}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe/{id}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');

    // Rutas para Likes
    Route::post('/like/{id}', [LikeController::class, 'like'])->name('like');
    Route::post('/unlike/{id}', [LikeController::class, 'unlike'])->name('unlike');

    // Rutas para Shares
    Route::post('/share/{id}', [ShareController::class, 'share'])->name('share');

    // Rutas para Comments
    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.store');

    // Ruta para estadísticas
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('/statistics/reset', [StatisticsController::class, 'reset'])->name('statistics.reset');

    // Ruta para configuraciones
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
