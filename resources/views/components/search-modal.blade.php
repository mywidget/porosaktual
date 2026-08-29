@props([])

<div
    x-data="{
        open: false,
        query: '',
        results: [],
        loading: false,
        timeout: null,
        search() {
            clearTimeout(this.timeout);
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            this.loading = true;
            this.timeout = setTimeout(() => {
                fetch(`{{ route('api.search') }}?q=${encodeURIComponent(this.query)}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    this.results = data.results || [];
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                    this.results = [];
                });
            }, 300);
        },
        close() {
            this.open = false;
            this.query = '';
            this.results = [];
        }
    }"
    x-on:keydown.escape.window="close()"
    x-on:open-search.window="open = true; $nextTick(() => $refs.searchInput.focus())"
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm"
        x-on:click.self="close()"
        style="display: none;"
    >
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="max-w-2xl mx-auto mt-20 mx-4"
        >
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        x-ref="searchInput"
                        x-model="query"
                        x-on:input="search()"
                        type="text"
                        placeholder="Cari berita..."
                        class="w-full pl-14 pr-14 py-5 bg-transparent text-gray-900 dark:text-white text-lg placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                    >
                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center">
                        <button
                            @click="close()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        >
                            <kbd class="px-2 py-1 text-xs font-medium text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600">
                                ESC
                            </kbd>
                        </button>
                    </div>
                </div>

                <div
                    x-show="query.length >= 2"
                    class="border-t border-gray-100 dark:border-gray-700 max-h-96 overflow-y-auto"
                >
                    <div x-show="loading" class="p-8 text-center">
                        <svg class="animate-spin h-6 w-6 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                    </div>

                    <div x-show="!loading && results.length === 0 && query.length >= 2" class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Tidak ditemukan hasil untuk "<span x-text="query" class="font-medium"></span>"</p>
                    </div>

                    <div x-show="!loading && results.length > 0" class="divide-y divide-gray-100 dark:divide-gray-700">
                        <template x-for="result in results" :key="result.id">
                            <a
                                :href="result.url"
                                class="flex items-start gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                            >
                                <template x-if="result.image">
                                    <img :src="result.image" :alt="result.title" class="w-16 h-12 object-cover rounded-lg flex-shrink-0">
                                </template>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        x-text="result.title"
                                        class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-1"
                                    ></h4>
                                    <p
                                        x-text="result.excerpt"
                                        class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2"
                                    ></p>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <template x-if="result.category">
                                            <span
                                                x-text="result.category"
                                                class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-medium"
                                            ></span>
                                        </template>
                                        <span
                                            x-text="result.date"
                                            class="text-[10px] text-gray-400 dark:text-gray-500"
                                        ></span>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </template>
                    </div>
                </div>

                <div x-show="query.length < 2" class="p-6 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-400 dark:text-gray-500 text-center">
                        Ketik minimal 2 karakter untuk mulai mencari
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>