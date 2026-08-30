<?php $__env->startSection('title', $post->meta_title ?? $post->title . ' - ' . config('app.name')); ?>

<?php $__env->startPush('meta'); ?>
    <meta name="description" content="<?php echo e($post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->content), 160)); ?>">
    <meta name="keywords" content="<?php echo e($post->meta_keywords ?? $post->tags->pluck('name')->implode(', ')); ?>">
    <meta property="og:title" content="<?php echo e($post->meta_title ?? $post->title); ?>">
    <meta property="og:description" content="<?php echo e($post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->content), 160)); ?>">
    <meta property="og:image" content="<?php echo e($post->featured_image_url); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($post->meta_title ?? $post->title); ?>">
    <meta name="twitter:description" content="<?php echo e($post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->content), 160)); ?>">
    <meta name="twitter:image" content="<?php echo e($post->featured_image_url); ?>">
    <?php if($post->published_at): ?>
        <meta property="article:published_time" content="<?php echo e($post->published_at->toIso8601String()); ?>">
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="application/ld+json">
    <?php echo json_encode([
        '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $post->title,
        'description' => $post->meta_description ?? Str::limit(strip_tags($post->excerpt ?? $post->content), 160),
        'image' => $post->featured_image_url,
        'datePublished' => $post->published_at?->toIso8601String(),
        'dateModified' => $post->updated_at?->toIso8601String(),
        'author' => [
            '@type' => 'Person',
            'name' => $post->author->name,
            'url' => route('author.show', $post->author->slug),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current(),
        ],
        'articleSection' => $post->category->name,
        'keywords' => $post->tags->pluck('name')->implode(', '),
        'wordCount' => str_word_count(strip_tags($post->content)),
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6 flex-wrap">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <a href="<?php echo e(route('category.show', $post->category->slug)); ?>" class="hover:text-blue-700 transition"><?php echo e($post->category->name); ?></a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300 truncate max-w-[200px]"><?php echo e($post->title); ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        
        <div class="lg:col-span-2">

            
            <div class="flex items-center space-x-2 mb-4 flex-wrap">
                <a href="<?php echo e(route('category.show', $post->category->slug)); ?>"
                   class="inline-block px-3 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full hover:bg-blue-800 transition">
                    <?php echo e($post->category->name); ?>

                </a>
                <?php if($post->is_breaking): ?>
                    <span class="inline-block px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full animate-pulse">Breaking News</span>
                <?php endif; ?>
                <?php if($post->is_trending): ?>
                    <span class="inline-block px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full">Trending</span>
                <?php endif; ?>
                <?php if($post->is_sponsored): ?>
                    <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">Advertorial</span>
                <?php endif; ?>
            </div>

            
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-4"><?php echo e($post->title); ?></h1>

            
            <div class="flex items-center space-x-4 mb-6 text-sm text-gray-500 dark:text-gray-400 flex-wrap">
                <a href="<?php echo e(route('author.show', $post->author->slug)); ?>" class="flex items-center space-x-2 hover:text-blue-700 transition">
                    <img src="<?php echo e($post->author->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name)); ?>"
                         alt="<?php echo e($post->author->name); ?>" class="w-8 h-8 rounded-full">
                    <span class="font-medium text-gray-700 dark:text-gray-300"><?php echo e($post->author->name); ?></span>
                </a>
                <span>&middot;</span>
                <time datetime="<?php echo e($post->published_at->toIso8601String()); ?>"><?php echo e($post->published_at->format('d M Y, H:i')); ?></time>
                <span>&middot;</span>
                <span><?php echo e($post->reading_time ?? ceil(str_word_count(strip_tags($post->content)) / 200)); ?> min baca</span>
                <span>&middot;</span>
                <span><?php echo e(number_format($post->views_count)); ?> views</span>
            </div>

            
            <?php if($post->featured_image_url): ?>
                <figure class="mb-8">
                    <img src="<?php echo e($post->featured_image_url); ?>" alt="<?php echo e($post->title); ?>"
                         class="w-full rounded-xl object-cover aspect-[16/9]">
                    <?php if($post->image_caption): ?>
                        <figcaption class="text-center text-sm text-gray-500 mt-2 italic"><?php echo e($post->image_caption); ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endif; ?>

            
            <div class="flex items-center space-x-2 mb-8 pb-6 border-b">
                <span class="text-sm font-medium text-gray-500 mr-2">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text=<?php echo e(urlencode($post->title . ' ' . url()->current())); ?>"
                   target="_blank" rel="noopener"
                   class="p-2 bg-green-500 text-white rounded-full hover:bg-green-600 transition" aria-label="WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo e(urlencode($post->title)); ?>&url=<?php echo e(urlencode(url()->current())); ?>"
                   target="_blank" rel="noopener"
                   class="p-2 bg-sky-500 text-white rounded-full hover:bg-sky-600 transition" aria-label="Twitter">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(url()->current())); ?>"
                   target="_blank" rel="noopener"
                   class="p-2 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition" aria-label="Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode(url()->current())); ?>&title=<?php echo e(urlencode($post->title)); ?>"
                   target="_blank" rel="noopener"
                   class="p-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition" aria-label="LinkedIn">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href)" class="p-2 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition" aria-label="Salin Link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                </button>
            </div>

            
            <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'content','class' => 'mb-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'content','class' => 'mb-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>

            
            <div class="prose prose-lg dark:prose-invert max-w-none mb-8">
                <?php echo $post->content; ?>

            </div>

            
            <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'content','class' => 'my-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'content','class' => 'my-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>

            
            <?php if($post->tags->count()): ?>
                <div class="mt-8 pt-6 border-t">
                    <div class="flex items-center space-x-2 flex-wrap">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('tag.show', $tag->slug)); ?>"
                               class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 text-sm rounded-full transition">
                                <?php echo e($tag->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'content','class' => 'mt-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'content','class' => 'mt-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>

            
            <?php if(isset($relatedPosts) && $relatedPosts->count()): ?>
                <div class="mt-12">
                    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
                        <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
                        <span>Berita Terkait</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal14b498b52c33a1421ff8895e4557790f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal14b498b52c33a1421ff8895e4557790f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.post-card','data' => ['post' => $related]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal14b498b52c33a1421ff8895e4557790f)): ?>
<?php $attributes = $__attributesOriginal14b498b52c33a1421ff8895e4557790f; ?>
<?php unset($__attributesOriginal14b498b52c33a1421ff8895e4557790f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal14b498b52c33a1421ff8895e4557790f)): ?>
<?php $component = $__componentOriginal14b498b52c33a1421ff8895e4557790f; ?>
<?php unset($__componentOriginal14b498b52c33a1421ff8895e4557790f); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if(($settings['comment_enabled'] ?? '0') === '1'): ?>
            <div class="mt-12 pt-8 border-t">
                <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>Komentar (<?php echo e($post->comments->where('status', 'approved')->count()); ?>)</span>
                </h2>

                
                <form id="commentForm" class="mb-8" x-data="{ submitting: false, message: '' }" @submit.prevent="submitComment">
                    <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
                    <div class="space-y-3">
                        <?php if(auth()->guard()->check()): ?>
                            <input type="text" name="name" value="<?php echo e(auth()->user()->name); ?>" readonly
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg text-sm bg-gray-50 dark:bg-gray-900">
                            <input type="email" name="email" value="<?php echo e(auth()->user()->email); ?>" readonly
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg text-sm bg-gray-50 dark:bg-gray-900">
                        <?php else: ?>
                            <input type="text" name="name" required placeholder="Nama Anda"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <input type="email" name="email" required placeholder="Email Anda"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <?php endif; ?>
                        <textarea name="content" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                                  placeholder="Tulis komentar Anda..."></textarea>
                        <div class="flex items-center justify-between">
                            <p x-show="message" :class="message.includes('berhasil') ? 'text-green-600' : 'text-red-600'" x-text="message" class="text-sm"></p>
                            <button type="submit" :disabled="submitting" class="px-6 py-2 bg-blue-700 text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition disabled:opacity-50">
                                <span x-show="!submitting">Kirim Komentar</span>
                                <span x-show="submitting">Mengirim...</span>
                            </button>
                        </div>
                    </div>
                </form>

                
                <div class="space-y-6">
                    <?php $__currentLoopData = $post->comments->where('status', 'approved'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex space-x-3">
                            <img src="<?php echo e($comment->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->name)); ?>"
                                 alt="" class="w-10 h-10 rounded-full flex-shrink-0">
                            <div class="flex-1 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-semibold text-sm"><?php echo e($comment->name); ?></span>
                                    <span class="text-xs text-gray-500"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><?php echo e($comment->content); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($post->comments->where('status', 'approved')->isEmpty()): ?>
                        <p class="text-center text-gray-500 py-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <aside class="space-y-8">

            
            <?php if($tocItems ?? false): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 sticky top-24 hidden lg:block">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-4">Daftar Isi</h3>
                    <nav class="space-y-2">
                        <?php $__currentLoopData = $tocItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#<?php echo e($item['id']); ?>"
                               class="block text-sm text-gray-600 dark:text-gray-400 hover:text-blue-700 transition
                                      <?php echo e($item['level'] == 3 ? 'pl-4' : ''); ?>">
                                <?php echo e($item['text']); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </nav>
                </div>
            <?php endif; ?>

            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-4">Penulis</h3>
                <a href="<?php echo e(route('author.show', $post->author->slug)); ?>" class="flex items-center space-x-3 group">
                    <img src="<?php echo e($post->author->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name)); ?>"
                         alt="" class="w-12 h-12 rounded-full">
                    <div>
                        <h4 class="font-semibold group-hover:text-blue-700 transition"><?php echo e($post->author->name); ?></h4>
                        <p class="text-xs text-gray-500"><?php echo e($post->author->posts_count ?? $post->author->posts()->count()); ?> artikel</p>
                    </div>
                </a>
                <?php if($post->author->bio): ?>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400"><?php echo e(Str::limit($post->author->bio, 120)); ?></p>
                <?php endif; ?>
            </div>

            
            <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'sidebar','limit' => 2]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'sidebar','limit' => 2]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
        </aside>
    </div>
</article>

<?php $__env->startPush('scripts'); ?>
<script>
    function submitComment() {
        const form = document.getElementById('commentForm');
        this.submitting = true;
        this.message = '';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        fetch('<?php echo e(route("comment.store")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(r => r.json())
        .then(res => {
            this.submitting = false;
            this.message = res.message;
            if (res.success) {
                form.reset();
                form.querySelector('input[name="post_id"]').value = '<?php echo e($post->id); ?>';
            }
        })
        .catch(() => {
            this.submitting = false;
            this.message = 'Terjadi kesalahan. Silakan coba lagi.';
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\porosaktual\resources\views/frontend/post/show.blade.php ENDPATH**/ ?>