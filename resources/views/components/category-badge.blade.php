@props(['category', 'size' => 'sm'])

@php
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
@endphp

<a
    href="{{ route('category.show', $categorySlug) }}"
    class="inline-block rounded-full {{ $sizeClass }} {{ $colorClass }} font-semibold hover:opacity-80 transition-opacity whitespace-nowrap"
>
    {{ $categoryName }}
</a>