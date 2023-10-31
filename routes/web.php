<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('layouts/app');
});

// Route::middleware(['auth'])->group(function(){
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::softDeletes('users', UserController::class);
    // Route::get('users/{user}/trash', [UserController::class, 'trash'])->name('users.trashed');
    // Route::get('/trashed', [UserController::class, 'trashed'])->name('users.trashed');
    // Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    // Route::delete('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
// });