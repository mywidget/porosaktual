<?php $__env->startSection('title', ($page->meta_title ?? $page->title) . ' - ' . config('app.name')); ?>

<?php $__env->startPush('meta'); ?>
    <?php if($page->meta_description): ?>
        <meta name="description" content="<?php echo e($page->meta_description); ?>">
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-8">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300"><?php echo e($page->title); ?></span>
    </nav>

    
    <article>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-8 leading-tight"><?php echo e($page->title); ?></h1>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            <?php echo $page->content; ?>

        </div>
    </article>

    
    <?php if($page->updated_at): ?>
        <div class="mt-10 pt-6 border-t text-sm text-gray-500">
            Terakhir diperbarui: <?php echo e($page->updated_at->format('d F Y, H:i')); ?> WIB
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\porosaktual\resources\views/frontend/page/show.blade.php ENDPATH**/ ?>