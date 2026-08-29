<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\TagController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\AuthorController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\RssController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BreakingNewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');
Route::get('/pencarian', [SearchController::class, 'search'])->name('search.search');
Route::get('/pencarian/ajax', [SearchController::class, 'searchAjax'])->name('search.ajax');
Route::get('/penulis/{slug}', [AuthorController::class, 'show'])->name('author.show');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
Route::post('/komentar', [CommentController::class, 'store'])->name('comment.store');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/news-sitemap.xml', [SitemapController::class, 'news'])->name('sitemap.news');
Route::get('/feed', [RssController::class, 'index'])->name('rss');

// Auth Routes (Breeze)
require __DIR__.'/auth.php';

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class);
    Route::post('posts/bulk-action', [AdminPostController::class, 'bulkAction'])->name('posts.bulk-action');
    Route::post('posts/{post}/publish', [AdminPostController::class, 'publish'])->name('posts.publish');
    Route::post('posts/{post}/schedule', [AdminPostController::class, 'schedule'])->name('posts.schedule');
    Route::post('posts/{post}/trending', [AdminPostController::class, 'toggleTrending'])->name('posts.trending');
    Route::post('posts/{post}/breaking', [AdminPostController::class, 'toggleBreaking'])->name('posts.breaking');
    Route::post('posts/{post}/highlight', [AdminPostController::class, 'toggleHighlight'])->name('posts.highlight');

    Route::resource('categories', AdminCategoryController::class);
    Route::resource('tags', AdminTagController::class);
    Route::get('tags-search', [AdminTagController::class, 'search'])->name('tags.search');
    Route::post('tags-create', [AdminTagController::class, 'storeAjax'])->name('tags.storeAjax');
    Route::resource('users', UserController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('advertisements', AdvertisementController::class);
    Route::post('advertisements/{advertisement}/toggle', [AdvertisementController::class, 'toggleActive'])->name('advertisements.toggle');
    Route::resource('comments', AdminCommentController::class)->only(['index', 'destroy']);
    Route::match(['post', 'patch'], 'comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::resource('menus', MenuController::class);
    Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/website', [SettingController::class, 'website'])->name('settings.website');
    Route::get('settings/social', [SettingController::class, 'social'])->name('settings.social');
    Route::get('settings/analytics', [SettingController::class, 'analytics'])->name('settings.analytics');
    Route::resource('breaking-news', BreakingNewsController::class);
    Route::post('breaking-news/{breaking_news}/toggle', [BreakingNewsController::class, 'toggle'])->name('breaking-news.toggle');
});
