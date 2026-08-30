<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['category', 'size' => 'sm']));

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

foreach (array_filter((['category', 'size' => 'sm']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizes = [
        'sm' => 'px-2.5 py-0.5 text-[10px]',
        'md' => 'px-3 py-1 text-xs',
        'lg' => 'px-4 py-1.5 text-sm',
    ];

    $colors = [
        'politik' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        'ekonomi' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        'teknologi' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'olahraga' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
        'hiburan' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
        'kesehatan' => 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
        'pendidikan' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
        'otomotif' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
        'lifestyle' => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['sm'];
    $categoryName = is_object($category) ? $category->name : $category;
    $categorySlug = is_object($category) ? $category->slug : Str::slug($categoryName);
    $colorClass = $colors[strtolower($categoryName)] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
?>

<a
    href="<?php echo e(route('category.show', $categorySlug)); ?>"
    class="inline-block rounded-full <?php echo e($sizeClass); ?> <?php echo e($colorClass); ?> font-semibold hover:opacity-80 transition-opacity whitespace-nowrap"
>
    <?php echo e($categoryName); ?>

</a><?php /**PATH E:\laragon\www\porosaktual\resources\views/components/category-badge.blade.php ENDPATH**/ ?>