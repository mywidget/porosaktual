<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BreakingNewsController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('api.posts.show');
    Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('/categories/{slug}/posts', [CategoryController::class, 'posts'])->name('api.categories.posts');
    Route::get('/tags', [TagController::class, 'index'])->name('api.tags.index');
    Route::get('/trending', [PostController::class, 'trending'])->name('api.trending');
    Route::get('/breaking-news', [BreakingNewsController::class, 'index'])->name('api.breaking-news');
    Route::get('/ads/{slot}', [AdvertisementController::class, 'index'])->name('api.ads');
    Route::get('/search', [SearchController::class, 'index'])->name('api.search');
});
