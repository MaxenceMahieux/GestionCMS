<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Middlewares */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Toutes les routes des différents controller et de leurs méthodes */

Route::resource('/', HomeController::class);
Route::resource('/menu', MenuController::class);
Route::resource('/submenu', SubmenuController::class);
Route::resource('/page', PageController::class);

/* Language */

Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->middleware(['auth', 'verified'])->name('change.language');

/* Mails */

Route::get('/mail/store/menu', function() {
    return view('mail.store.menu');
});

Route::get('/mail/store/submenu', function() {
    return view('mail.store.submenu');
});

Route::get('/mail/store/page', function() {
    return view('mail.store.page');
});

Route::get('/mail/edit/menu', function() {
    return view('mail.edit.menu');
});

Route::get('/mail/edit/submenu', function() {
    return view('mail.edit.submenu');
});

Route::get('/mail/edit/page', function() {
    return view('mail.edit.page');
});

/* Requires */

require __DIR__.'/auth.php';
