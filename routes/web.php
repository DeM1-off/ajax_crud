<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LiveSearch;
use  App\Http\Controllers\AuthorSearch;
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
    return view('layout');
});

Route::resource('book',BookController::class);

Route::resource('author',AuthorController::class);



Route::get('search',[LiveSearch::class, 'index'])->name('search');
Route::get('search/action', [LiveSearch::class, 'action'])->name('search.action');
Route::get('search_author',[AuthorSearch::class, 'index'])->name('search_author');
Route::get('search_author/action', [AuthorSearch::class, 'action'])->name('search_author.action');

