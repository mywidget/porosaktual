<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class SeoService
{
    public function getMetaTags(Post $post): array
    {
        return [
            'title' => $post->meta_title ?: $post->title,
            'description' => $post->meta_description ?: $post->excerpt,
            'keywords' => $post->meta_keywords ?: $post->tags->pluck('name')->implode(', '),
            'canonical' => route('post.show', $post->slug),
            'robots' => 'index, follow',
        ];
    }

    public function getOpenGraph(Post $post): array
    {
        return [
            'og:title' => $post->meta_title ?: $post->title,
            'og:description' => $post->meta_description ?: $post->excerpt,
            'og:image' => $post->og_image ?: $post->featured_image,
            'og:url' => route('post.show', $post->slug),
            'og:type' => 'article',
            'og:site_name' => config('app.name'),
            'og:locale' => 'id_ID',
            'article:published_time' => $post->published_at ? $post->published_at->toIso8601String() : null,
            'article:author' => $post->author->name,
            'article:section' => $post->category->name,
            'article:tag' => $post->tags->pluck('name')->toArray(),
        ];
    }

    public function getJsonLd(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $post->title,
            'description' => $post->meta_description ?: $post->excerpt,
            'image' => $post->featured_image,
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : null,
            'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : null,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('post.show', $post->slug),
            ],
            'articleSection' => $post->category->name,
            'keywords' => $post->tags->pluck('name')->implode(', '),
            'wordCount' => str_word_count(strip_tags($post->content)),
            'timeRequired' => "PT{$post->reading_time}M",
        ];
    }

    public function getJsonLdOrganization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
            'sameAs' => [
                config('social.facebook', ''),
                config('social.twitter', ''),
                config('social.instagram', ''),
                config('social.youtube', ''),
            ],
        ];
    }

    public function getJsonLdBreadcrumb(array $breadcrumbs): array
    {
        $items = array_map(function ($index, $item) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }, array_keys($breadcrumbs), $breadcrumbs);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    public function getJsonLdWebsite(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name'),
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/search?q={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function generateSitemap(): string
    {
        $posts = Post::query()
            ->published()
            ->select(['slug', 'updated_at', 'published_at'])
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';

        foreach ($posts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('post.show', $post->slug) . '</loc>';
            $xml .= '<lastmod>' . $post->updated_at->toDateString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    public function generateNewsSitemap(): string
    {
        $posts = Post::query()
            ->published()
            ->where('published_at', '>=', now()->subDays(2))
            ->with('category')
            ->select(['title', 'slug', 'published_at', 'category_id'])
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml .= ' xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';

        foreach ($posts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('post.show', $post->slug) . '</loc>';
            $xml .= '<news:news>';
            $xml .= '<news:publication>';
            $xml .= '<news:name>' . config('app.name') . '</news:name>';
            $xml .= '<news:language>id</news:language>';
            $xml .= '</news:publication>';
            $xml .= '<news:publication_date>' . $post->published_at->toIso8601String() . '</news:publication_date>';
            $xml .= '<news:title>' . htmlspecialchars($post->title) . '</news:title>';
            $xml .= '</news:news>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
