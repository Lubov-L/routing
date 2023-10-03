<?php


use Routing\App\Http\Controllers\PostController;
use Routing\App\RMVC\Route\Route;

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth');
Route::post('/posts', [PostController::class, 'load'])->name('posts.load')->middleware('auth');
Route::get('/posts/{post}/', [PostController::class, 'show'])->name('posts.show')->middleware('auth');