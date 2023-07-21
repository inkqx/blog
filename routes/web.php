<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\PostController;

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
    return view('blog');
});

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.home');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'showPost'])->name('blog.detail');


// 后台
Route::get('/admin', function () {
    return redirect('/admin/post');
})->name('admin');
Route::middleware('auth')->group(function () {
    Route::resource('admin/post', PostController::class);
    Route::resource('admin/tag', \App\Http\Controllers\Admin\TagController::class);
    Route::get('admin/upload', [\App\Http\Controllers\Admin\UploadController::class,'index']);
});

Route::get('/login',[\App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class,'login']);
Route::get('/logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
