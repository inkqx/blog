<?php

use \App\Http\Controllers\BlogController;
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
// 节流测试，10秒内10次
Route::get('/test', [BlogController::class, 'test'])->middleware('throttle:10,10')->name('blog.test');

// 博文
Route::get('/blog', [BlogController::class, 'index'])->name('blog.home');
Route::get('/blog/{slug}', [BlogController::class, 'showPost'])->name('blog.detail');

// 后台
Route::get('/admin', function () {
    return redirect('/admin/post');
})->name('admin');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('/post', PostController::class);
    Route::resource('/tag', \App\Http\Controllers\Admin\TagController::class, ['except' => 'show']);

    // 文件上传管理
    // Route::get('admin/tag/{id}/edit', [\App\Http\Controllers\Admin\UploadController::class,'edit']);
    Route::get('/upload', [\App\Http\Controllers\Admin\UploadController::class, 'index']);
    // 添加如下路由
    Route::post('/upload/file', [\App\Http\Controllers\Admin\UploadController::class, 'uploadFile']);
    Route::delete('/upload/file', [\App\Http\Controllers\Admin\UploadController::class, 'deleteFile']);
    Route::post('/upload/folder', [\App\Http\Controllers\Admin\UploadController::class, 'createFolder']);
    Route::delete('/upload/folder', [\App\Http\Controllers\Admin\UploadController::class, 'deleteFolder']);
    Route::resource('/post', PostController::class);
    Route::resource('/tag', \App\Http\Controllers\Admin\TagController::class, ['except' => 'show']);

    // 文件上传管理
    // Route::get('admin/tag/{id}/edit', [\App\Http\Controllers\Admin\UploadController::class,'edit']);
    // Route::get('admin/upload', [\App\Http\Controllers\Admin\UploadController::class, 'index']);
    // // 添加如下路由
    // Route::post('admin/upload/file', [\App\Http\Controllers\Admin\UploadController::class, 'uploadFile']);
    // Route::delete('admin/upload/file', [\App\Http\Controllers\Admin\UploadController::class, 'deleteFile']);
    // Route::post('admin/upload/folder', [\App\Http\Controllers\Admin\UploadController::class, 'createFolder']);
    // Route::delete('admin/upload/folder', [\App\Http\Controllers\Admin\UploadController::class, 'deleteFolder']);
});

// 登录
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


// 兜底路由
Route::fallback(function (){
    return '已失效的网址';
});

// Auth::routes();
//
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
