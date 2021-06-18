<?php

use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('index');