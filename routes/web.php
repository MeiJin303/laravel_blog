<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostReaderController;
use App\Http\Controllers\PostWriterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostReaderController::class, 'index'])->name('home');

Route::get('/dashboard', [PostReaderController::class, 'userPosts'])->middleware(['auth'])->name('dashboard');

Route::get('/add_post', [PostWriterController::class, 'addPost'])->middleware(['auth'])->name('addPost');

Route::post('/add_post', [PostWriterController::class, 'addPost'])->middleware(['auth']);

// Admin route
Route::get('/admin', [AdminController::class, 'index'])->middleware('is_admin')->name('admin');

Route::any('/admin/add', [AdminController::class, 'addApiUrl'])->middleware('is_admin');

Route::any('/admin/edit/{id?}', [AdminController::class, 'editApiUrl'])->middleware('is_admin');

Route::post('/admin/remove/{id}', [AdminController::class, 'removeApiUrl'])->middleware('is_admin');

require __DIR__.'/auth.php';
