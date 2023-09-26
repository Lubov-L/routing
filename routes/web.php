<?php

use Routing\App\Controller\PostController;
use Routing\App\RMVC\Route\Route;

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth');