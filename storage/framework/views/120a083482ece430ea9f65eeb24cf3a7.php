<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['location' => 'header', 'limit' => 3]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['location' => 'header', 'limit' => 3]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $advertisements = \App\Models\Advertisement::whereHas('slot', function ($q) use ($location) {
        $q->where('location', $location)->where('is_active', true);
    })
        ->where('is_active', true)
        ->where(function ($q) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', now());
        })
        ->where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', now());
        })
        ->with('slot')
        ->limit($limit)
        ->get();
?>

<?php if($advertisements->count()): ?>
    <div class="<?php echo e($attributes->get('class', '')); ?>">
        <?php $__currentLoopData = $advertisements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advertisement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ad-container relative my-4">
                <div class="text-center text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                    Advertisement
                </div>
                <div class="rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-center">
                    <?php if($advertisement->type === 'banner' && $advertisement->banner_image): ?>
                        <a href="<?php echo e($advertisement->url ?? '#'); ?>" target="_blank" rel="noopener noreferrer nofollow" class="block">
                            <img
                                src="<?php echo e(asset('storage/' . $advertisement->banner_image)); ?>"
                                alt="<?php echo e($advertisement->title); ?>"
                                class="w-full h-auto object-cover"
                                loading="lazy"
                            >
                        </a>
                    <?php elseif($advertisement->type === 'html_script' && $advertisement->html_code): ?>
                        <div class="ad-html p-2 md:p-4">
                            <?php echo $advertisement->html_code; ?>

                        </div>
                    <?php elseif($advertisement->type === 'adsense' && $advertisement->html_code): ?>
                        <div class="ad-adsense p-2 md:p-4">
                            <?php echo $advertisement->html_code; ?>

                        </div>
                    <?php elseif($advertisement->type === 'internal' && $advertisement->url): ?>
                        <a href="<?php echo e($advertisement->url); ?>" class="block p-4 text-sm font-medium text-blue-700 dark:text-blue-400 hover:underline">
                            <?php echo e($advertisement->title); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH E:\laragon\www\porosaktual\resources\views/components/ad-slot.blade.php ENDPATH**/ ?>