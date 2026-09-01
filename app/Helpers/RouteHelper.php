<?php

/**
 * Route Helper - WordPress-style customizable route prefixes
 *
 * Helper functions untuk generate URL berdasarkan prefix yang dikonfigurasi.
 * Prefix disimpan di database (settings table) dan di-cache.
 */

if (!function_exists('route_prefix')) {
    /**
     * Get the configured prefix for a route type
     */
    function route_prefix(string $type): string
    {
        $settings = \App\Services\SettingService::getAllSettings();
        return $settings["route_{$type}_prefix"] ?? config("RoutesConfig.prefixes.{$type}", '');
    }
}

if (!function_exists('post_url')) {
    /**
     * Generate URL for a post
     * Example: /news/my-post-slug or /my-post-slug (if prefix is empty)
     */
    function post_url(\App\Models\Post $post): string
    {
        $prefix = route_prefix('post');
        return $prefix ? "/{$prefix}/{$post->slug}" : "/{$post->slug}";
    }
}

if (!function_exists('category_url')) {
    /**
     * Generate URL for a category
     */
    function category_url(\App\Models\Category $category): string
    {
        $prefix = route_prefix('category');
        return $prefix ? "/{$prefix}/{$category->slug}" : "/{$category->slug}";
    }
}

if (!function_exists('tag_url')) {
    /**
     * Generate URL for a tag
     */
    function tag_url(\App\Models\Tag $tag): string
    {
        $prefix = route_prefix('tag');
        return $prefix ? "/{$prefix}/{$tag->slug}" : "/{$tag->slug}";
    }
}

if (!function_exists('author_url')) {
    /**
     * Generate URL for an author
     */
    function author_url(\App\Models\User $author): string
    {
        $prefix = route_prefix('author');
        $slug = $author->slug ?? \Illuminate\Support\Str::slug($author->name);
        return $prefix ? "/{$prefix}/{$slug}" : "/{$slug}";
    }
}

if (!function_exists('page_url')) {
    /**
     * Generate URL for a page
     */
    function page_url(\App\Models\Page $page): string
    {
        $prefix = route_prefix('page');
        return $prefix ? "/{$prefix}/{$page->slug}" : "/{$page->slug}";
    }
}

if (!function_exists('search_url')) {
    /**
     * Generate URL for search
     */
    function search_url(?string $query = null): string
    {
        $prefix = route_prefix('search');
        $base = $prefix ? "/{$prefix}" : '/search';
        return $query ? "{$base}?q=" . urlencode($query) : $base;
    }
}

if (!function_exists('video_url')) {
    /**
     * Generate URL for video listing
     */
    function video_url(): string
    {
        $prefix = route_prefix('video');
        return $prefix ? "/{$prefix}" : '/videos';
    }
}

if (!function_exists('route_with_prefix')) {
    /**
     * Generate URL using named route with prefix override
     */
    function route_with_prefix(string $type, string $slug): string
    {
        $prefix = route_prefix($type);
        return $prefix ? "/{$prefix}/{$slug}" : "/{$slug}";
    }
}
