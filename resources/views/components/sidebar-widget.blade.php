@props(['title' => '', 'slot' => ''])

<div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
    @if($title)
        <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide flex items-center gap-2">
                <span class="w-1 h-4 bg-blue-600 rounded-full"></span>
                {{ $title }}
            </h3>
        </div>
    @endif

    <div class="p-5">
        {{ $slot }}
    </div>
</div>