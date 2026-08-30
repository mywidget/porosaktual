<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\AdvertisementService;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\SeoService;
use App\Services\VisitorService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $postService;
    protected CommentService $commentService;
    protected SeoService $seoService;
    protected VisitorService $visitorService;
    protected AdvertisementService $advertisementService;

    public function __construct(
        PostService $postService,
        CommentService $commentService,
        SeoService $seoService,
        VisitorService $visitorService,
        AdvertisementService $advertisementService
    ) {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->seoService = $seoService;
        $this->visitorService = $visitorService;
        $this->advertisementService = $advertisementService;
    }

    public function show(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with(['author', 'category', 'tags'])
            ->firstOrFail();

        $this->postService->incrementViews($post, $request);

        $relatedPosts = $this->postService->getRelatedPosts($post, 5);
        $popularPosts = $this->postService->getPopularPostsThisWeek(10);
        $comments = $this->commentService->getApprovedComments($post->id);
        $commentCount = $this->commentService->getCommentCount($post->id);

        $seoMeta = $this->seoService->getMetaTags($post);
        $openGraph = $this->seoService->getOpenGraph($post);
        $jsonLd = $this->seoService->getJsonLd($post);

        $breadcrumbs = $this->seoService->getJsonLdBreadcrumb([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $post->category->name, 'url' => route('category.show', $post->category->slug)],
            ['name' => $post->title, 'url' => route('post.show', $post->slug)],
        ]);

        $adsSidebar = $this->advertisementService->getAdsForSlot('post-sidebar');
        $adsInline = $this->advertisementService->getAdsForSlot('post-inline');
        $adsBottom = $this->advertisementService->getAdsForSlot('post-bottom');

        $tags = $post->tags;

        return view('frontend.post.show', compact(
            'post',
            'relatedPosts',
            'popularPosts',
            'comments',
            'commentCount',
            'seoMeta',
            'openGraph',
            'jsonLd',
            'breadcrumbs',
            'adsSidebar',
            'adsInline',
            'adsBottom',
            'tags',
        ));
    }
}
