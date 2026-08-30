<?php $__env->startSection('title', $settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya'); ?>

<?php $__env->startPush('meta'); ?>
    <meta name="description" content="<?php echo e($settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia. Temukan berita politik, nasional, ekonomi, teknologi, olahraga, dan lifestyle terbaru.'); ?>">
    <meta name="keywords" content="<?php echo e($settings['seo_meta_keywords'] ?? 'berita, news, Indonesia, terkini, politik, nasional, ekonomi, teknologi, olahraga, lifestyle'); ?>">
    <meta property="og:title" content="<?php echo e($settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya'); ?>">
    <meta property="og:description" content="<?php echo e($settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia. Temukan berita politik, nasional, ekonomi, teknologi, olahraga, dan lifestyle terbaru.'); ?>">
    <meta property="og:image" content="<?php echo e(($settings['seo_og_image'] ?? null) ? asset('storage/' . $settings['seo_og_image']) : asset('images/no-image.svg')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($settings['seo_meta_title'] ?? config('app.name', 'Poros Aktual') . ' - Portal Berita Terpercaya'); ?>">
    <meta name="twitter:description" content="<?php echo e($settings['seo_meta_description'] ?? 'Portal berita terkini Indonesia.'); ?>">
    <meta name="twitter:image" content="<?php echo e(($settings['seo_og_image'] ?? null) ? asset('storage/' . $settings['seo_og_image']) : asset('images/no-image.svg')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <?php if(isset($heroPost)): ?>
            <div class="lg:col-span-2">
                <a href="<?php echo e(route('post.show', $heroPost->slug)); ?>" class="group block relative rounded-2xl overflow-hidden aspect-[16/9]">
                    <img src="<?php echo e($heroPost->featured_image_url); ?>" alt="<?php echo e($heroPost->title); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block px-3 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full mb-3"><?php echo e($heroPost->category->name); ?></span>
                        <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight group-hover:text-blue-300 transition"><?php echo e($heroPost->title); ?></h1>
                        <div class="flex items-center space-x-3 mt-3 text-gray-300 text-sm">
                            <span><?php echo e($heroPost->author->name); ?></span>
                            <span>&middot;</span>
                            <span><?php echo e($heroPost->published_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        
        <div class="flex flex-col gap-4">
            <?php if(isset($featuredPosts)): ?>
                <?php $__currentLoopData = $featuredPosts->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="group block relative rounded-xl overflow-hidden aspect-[16/9]">
                        <img src="<?php echo e($post->featured_image_url); ?>" alt="<?php echo e($post->title); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <span class="inline-block px-2 py-0.5 bg-blue-700 text-white text-xs font-semibold rounded-full mb-2"><?php echo e($post->category->name); ?></span>
                            <h3 class="text-sm font-bold text-white leading-snug group-hover:text-blue-300 transition"><?php echo e(Str::limit($post->title, 80)); ?></h3>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php if(isset($trendingPosts) && $trendingPosts->count()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
            <span>Trending</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $trendingPosts->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal14b498b52c33a1421ff8895e4557790f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal14b498b52c33a1421ff8895e4557790f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.post-card','data' => ['post' => $post,'trending' => true,'rank' => $index + 1]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post),'trending' => true,'rank' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index + 1)]); ?>
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
</section>
<?php endif; ?>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'header']); ?>
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
</div>


<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
                <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
                <span>Berita Terbaru</span>
            </h2>
            <div class="space-y-6">
                <?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal1ebc34f2428490c9cf888d318ec0da2e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ebc34f2428490c9cf888d318ec0da2e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.post-card-horizontal','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card-horizontal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ebc34f2428490c9cf888d318ec0da2e)): ?>
<?php $attributes = $__attributesOriginal1ebc34f2428490c9cf888d318ec0da2e; ?>
<?php unset($__attributesOriginal1ebc34f2428490c9cf888d318ec0da2e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ebc34f2428490c9cf888d318ec0da2e)): ?>
<?php $component = $__componentOriginal1ebc34f2428490c9cf888d318ec0da2e; ?>
<?php unset($__componentOriginal1ebc34f2428490c9cf888d318ec0da2e); ?>
<?php endif; ?>
                    <?php if($loop->iteration === 3): ?>
                        <div class="my-4"><?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'content']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'content']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $attributes = $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805)): ?>
<?php $component = $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805; ?>
<?php unset($__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805); ?>
<?php endif; ?></div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <aside class="space-y-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span>Populer</span>
                </h3>
                <?php if(isset($popularPosts)): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $popularPosts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="flex items-start space-x-3 group">
                                <span class="text-2xl font-extrabold text-gray-200 dark:text-gray-600 group-hover:text-blue-700 transition leading-none"><?php echo e($index + 1); ?></span>
                                <div>
                                    <h4 class="text-sm font-semibold leading-snug group-hover:text-blue-700 transition"><?php echo e(Str::limit($post->title, 70)); ?></h4>
                                    <span class="text-xs text-gray-500 mt-1 block"><?php echo e($post->published_at->diffForHumans()); ?></span>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-lg mb-4">Tag Populer</h3>
                <?php if(isset($popularTags)): ?>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $popularTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('tag.show', $tag->slug)); ?>"
                               class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-900 text-sm rounded-full transition">
                                <?php echo e($tag->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>


<div class="bg-blue-700 rounded-xl shadow-sm p-6 text-white">
    <h3 class="font-bold text-lg mb-2">Newsletter</h3>
    <p class="text-blue-100 text-sm mb-4">Dapatkan berita terkini langsung di inbox Anda.</p>
    <form action="#" method="POST" class="space-y-3">
        <?php echo csrf_field(); ?>
        <input type="email" name="email" placeholder="Email Anda" required
               class="w-full px-4 py-2.5 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-white outline-none">
        <button type="submit" class="w-full px-4 py-2.5 bg-white text-blue-700 font-semibold rounded-lg text-sm hover:bg-gray-100 transition">
            Berlangganan
        </button>
    </form>
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
</section>


<?php $__currentLoopData = ['politik', 'nasional', 'ekonomi', 'teknologi', 'lifestyle', 'olahraga']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorySlug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $categoryPosts = $categoryPostsMap[$categorySlug] ?? collect();
    ?>
    <?php if($categoryPosts->count()): ?>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold flex items-center space-x-2">
                <div class="w-1 h-6 bg-blue-700 rounded-full"></div>
                <span><?php echo e(ucfirst($categorySlug)); ?></span>
            </h2>
            <a href="<?php echo e(route('category.show', $categorySlug)); ?>" class="text-sm text-blue-700 hover:text-blue-800 font-medium flex items-center space-x-1">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <?php $headline = $categoryPosts->first(); ?>
            <div class="lg:col-span-2">
                <a href="<?php echo e(route('post.show', $headline->slug)); ?>" class="group block relative rounded-2xl overflow-hidden aspect-[16/9]">
                    <img src="<?php echo e($headline->featured_image_url); ?>" alt="<?php echo e($headline->title); ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block px-3 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full mb-3"><?php echo e($headline->category->name); ?></span>
                        <h3 class="text-2xl font-bold text-white leading-tight group-hover:text-blue-300 transition"><?php echo e($headline->title); ?></h3>
                        <div class="flex items-center space-x-3 mt-3 text-gray-300 text-sm">
                            <span><?php echo e($headline->author->name); ?></span>
                            <span>&middot;</span>
                            <span><?php echo e($headline->published_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="flex flex-col gap-4">
                <?php $__currentLoopData = $categoryPosts->skip(1)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="group block relative rounded-xl overflow-hidden aspect-[16/9]">
                        <img src="<?php echo e($post->featured_image_url); ?>" alt="<?php echo e($post->title); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h4 class="text-sm font-bold text-white leading-snug group-hover:text-blue-300 transition"><?php echo e(Str::limit($post->title, 80)); ?></h4>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(isset($videos) && $videos->count()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold flex items-center space-x-2">
            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <span>Video</span>
        </h2>
        <a href="<?php echo e(route('video.index')); ?>" class="text-sm text-blue-700 hover:text-blue-800 font-medium flex items-center space-x-1">
            <span>Lihat Semua</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $videos->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="group">
                <div class="aspect-video rounded-xl overflow-hidden bg-gray-200 dark:bg-gray-700 mb-3">
                    <?php if($video->youtube_id): ?>
                        <iframe src="https://www.youtube.com/embed/<?php echo e($video->youtube_id); ?>" class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                    <?php else: ?>
                        <img src="<?php echo e($video->featured_image_url); ?>" alt="<?php echo e($video->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <?php endif; ?>
                </div>
                <h3 class="font-semibold group-hover:text-blue-700 transition"><?php echo e(Str::limit($video->title, 70)); ?></h3>
                <span class="text-xs text-gray-500 mt-1 block"><?php echo e($video->published_at->diffForHumans()); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>


<?php if(isset($editorsChoice) && $editorsChoice->count()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        <span>Pilihan Redaksi</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $editorsChoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal14b498b52c33a1421ff8895e4557790f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal14b498b52c33a1421ff8895e4557790f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.post-card','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
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
</section>
<?php endif; ?>


<?php if(isset($popularThisWeek) && $popularThisWeek->count()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-xl font-bold mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
        <span>Populer Minggu Ini</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $popularThisWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal14b498b52c33a1421ff8895e4557790f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal14b498b52c33a1421ff8895e4557790f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.post-card','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('post-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
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
</section>
<?php endif; ?>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <?php if (isset($component)) { $__componentOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43e1d90ca5f26d2b3f1aa3bef8ea2805 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ad-slot','data' => ['location' => 'footer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ad-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['location' => 'footer']); ?>
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
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\porosaktual\resources\views/frontend/home.blade.php ENDPATH**/ ?>