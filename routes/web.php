<?php

use App\Http\Controllers\AdminCategoriesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMediasController;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommentRepliesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentsController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/post/{id}', [AdminPostsController::class, 'post'])->name('home.post');

Route::name('admin.')->group(function(){

    Route::get('logout', [LoginController::class, 'logout']);

    Route::group(['middleware'=>'admin'],function(){
        Route::get('/admin', [AdminController::class, 'index']);

        });
        Route::resource('admin/users',AdminUsersController::class);
//        Route::get('/post/{id}', [HomeController::class, 'post'])->name('home.post');
        Route::resource('admin/posts',AdminPostsController::class);
        Route::resource('admin/categories', AdminCategoriesController::class);
        Route::resource('admin/media', AdminMediasController::class);
        Route::delete('admin/delete/media', [AdminMediasController::class, 'deleteMedia']);
        Route::post('admin/media/upload', [AdminMediasController::class, 'store'])->name('media.upload');
        Route::resource('admin/comments', PostCommentsController::class);
        Route::resource('admin/comment/replies', CommentRepliesController::class);
    });

    Route::group(['middleware'=>'auth'],function(){
        Route::post('/comment/reply', [CommentRepliesController::class, 'createReply']);
    });

