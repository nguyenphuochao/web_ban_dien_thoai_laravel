<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
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

Route::get('login', [LoginController::class, 'login_form'])->name('login_form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('categories.index');
});

Route::resource('categories', CategoryController::class);
Route::post('categories/sort', [CategoryController::class, 'sort'])->name('categories.sort');
