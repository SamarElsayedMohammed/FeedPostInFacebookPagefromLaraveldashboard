<?php

use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use JoelButcher\Facebook\Facades\Facebook as FacebookFacade;
use JoelButcher\Facebook\Facebook;

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
    return view('getmodal');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::resource('post', PostController::class);
Route::get('/login/redirect/{provider}', [SocialiteController::class, 'redirectToFacebookProvider']);
Route::get('/login/{provider}/callback', [SocialiteController::class, 'ProviderCallBack']);
Route::get('/posts', [PostController::class, "index"]);

Route::get('/user-data', [FacebookController::class, 'getAccountID'])->middleware(['auth']);
Route::get('/post-to-page', [FacebookController::class, 'PostToPage'])->middleware(['auth']);
Route::get('/get-post', [FacebookController::class, 'getPost'])->middleware(['auth']);
Route::get('/update-post/{postId}', [FacebookController::class, 'UpdatePost'])->middleware(['auth']);
Route::get('/delete-post/{postId}', [FacebookController::class, 'deletePost'])->middleware(['auth']);
Route::get('/test', [FacebookController::class, 'Test'])->middleware(['auth']);
