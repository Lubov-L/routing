<?php

namespace Routing\App\Http\Controllers;

use Routing\App\RMVC\Route\Route;
use Routing\App\RMVC\View\View;

class PostController extends Controller
{
    public function index(): string
    {
        return View::view('post.index');
    }

    public function show($post): string
    {
        return View::view('post.show', compact('post'));
    }

    public function load(): void
    {
        $_SESSION['message'] = $_POST['title'];
        Route::redirect('/posts');
    }
}