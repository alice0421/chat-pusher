<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'authUser' => Auth::user(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// chat用のルーティング（Gateを使用、403エラー画面が出る）
// Route::middleware(['auth', 'can:chat,receiver'])->group(function () {
//     Route::get('/chat/{receiver}', [ChatController::class, 'get'])->name('chat.get');
//     Route::post('/chat/{receiver}', [ChatController::class, 'store'])->name('chat.store');
// });

// chat用のルーティング (Middlewareを自作、403エラーでbackする)
Route::middleware(['auth', 'chat'])->group(function () {
    Route::get('/chat/{receiver}', [ChatController::class, 'get'])->name('chat.get');
    Route::post('/chat/{receiver}', [ChatController::class, 'store'])->name('chat.store');
});

require __DIR__.'/auth.php';
