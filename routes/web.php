<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;


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
    return view('auth.login');
})->name('/');

Auth::routes();


// ======================= Admin Register
Route::get('/admin/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('admin.register');
Route::post('/admin/register/store', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('admin.register.store');

// ======================= Admin Login/Logout
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin.login');// Very imp line for session expire after 2hrs
Route::post('/admin/login/store', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('admin.login.store');
Route::post('/admin/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('admin.logout');


// ======================= Admin Dashboard
Route::group(['middleware' => ['auth:web']], function () {

    Route::get('/admin/dashboard', [HomeController::class, 'Admin_Home'])->name('admin.dashboard');

    // == create Blog Post
    Route::get('/blog-list', [BlogController::class, 'index'])->name('post.index');
    Route::get('/create-blog', [BlogController::class, 'Create'])->name('post.create');
    Route::post('/store-blog', [BlogController::class,  'Store'])->name('post.store');

    // == view Single blog post
    Route::get("/view-single-blog/{id}",[BlogController::class,'show'])->name("post.show");

    // == Comment Single blog post
    Route::post("/addComment/{blog_id}",[BlogController::class,"ParrentCommentPost"])->name("post.parrent.comment.add");

    // == reply Single blog post
    Route::post("/addreplyComment/{blog_id}",[BlogController::class,"ChildCommentPost"])->name("post.child.comment.add");
});
