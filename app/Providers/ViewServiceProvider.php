<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories', \App\Models\Category::where('is_active', true)->whereNull('parent_id')->with('children')->orderBy('sort_order')->get());
            $view->with('settings', \App\Services\SettingService::getAllSettings());
            $view->with('breakingNewsItems', \App\Models\BreakingNews::where('is_active', true)->where('start_date', '<=', now())->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })->orderBy('priority', 'desc')->limit(10)->get());
            $view->with('headerMenus', \App\Models\Menu::where('location', 'header')->where('is_active', true)->whereNull('parent_id')->with('children')->orderBy('sort_order')->get());
            $view->with('footerMenus', \App\Models\Menu::where('location', 'footer')->where('is_active', true)->whereNull('parent_id')->with('children')->orderBy('sort_order')->get());
        });
    }
}

