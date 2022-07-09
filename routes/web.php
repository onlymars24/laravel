<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UsersController;

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

Route::get('/create', [CreateController::class, 'form'])->name('create')->middleware('auth', 'permissionForPage');
Route::match(['post', 'get'], '/create-handler', [CreateController::class, 'handler'])->name('create-act')->middleware('thereIsHttpRequest');

Route::get('/edit/{id}', [EditController::class, 'form'])->name('edit')->middleware('auth', 'havingOfId', 'permissionForPage');
Route::match(['post', 'get'], '/edit-handler/{id}', [EditController::class, 'handler'])->name('edit-act')->middleware('thereIsHttpRequest');

Route::get('/login', [LoginController::class, 'form'])->name('login')->middleware('guest');
Route::match(['post', 'get'], '/login-handler', [LoginController::class, 'handler'])->name('login-act')->middleware('thereIsHttpRequest');

Route::get('/logout-handler', [LogoutController::class, 'logout'])->name('logout-act');

Route::get('/image/{id}', [ImageController::class, 'form'])->name('image')->middleware('auth', 'havingOfId', 'permissionForPage');
Route::match(['post', 'get'], '/image-handler/{id}', [ImageController::class, 'handler'])->name('image-act')->middleware('thereIsHttpRequest');

Route::get('/profile/{id}', [ProfileController::class, 'page'])->name('profile')->middleware('auth');

Route::get('/register', [RegisterController::class, 'form'])->name('register')->middleware('guest');
Route::match(['post', 'get'], '/register-handler', [RegisterController::class, 'handler'])->name('register-act')->middleware('thereIsHttpRequest');

Route::get('/security/{id}', [SecurityController::class, 'form'])->name('security')->middleware('auth', 'havingOfId', 'permissionForPage');
Route::match(['post', 'get'], '/security-handler/{id}', [SecurityController::class, 'handler'])->name('security-act')->middleware('thereIsHttpRequest');

Route::get('/status/{id}', [StatusController::class, 'form'])->name('status')->middleware('auth', 'havingOfId', 'permissionForPage');
Route::match(['post', 'get'], '/status-handler/{id}', [StatusController::class, 'handler'])->name('status-act')->middleware('thereIsHttpRequest');

Route::get('/delete-handler/{id}', [DeleteController::class, 'delete'])->name('delete')->middleware('auth', 'havingOfId', 'permissionForPage');

Route::get('/', [UsersController::class, 'page'])->name('users')->middleware('auth');