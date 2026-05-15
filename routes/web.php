<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

// form
Route::get('/home2', [BookController::class, 'index2'])->name('home.2');
Route::post('/create-book', [BookController::class, 'addBook'])->name('create.book');
Route::delete('/delete/book/{id}', [BookController::class, 'deleteBook'])->name('delete.book');
Route::put('/update/book/{id}', [BookController::class, 'updateBook'])->name('update.book');


// fetch
Route::get('/home3', [BookController::class, 'index']);
Route::post('/add-book', [BookController::class, 'store'])->name('add.book');
Route::put('/edit-book/{id}', [BookController::class, 'edit']);
Route::delete('/delete-book/{id}', [BookController::class, 'delete']);
