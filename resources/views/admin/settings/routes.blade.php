@extends('layouts.admin')

@section('title', 'Pengaturan Route')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pengaturan Route (URL)</h1>
        <a href="{{ route('admin.settings.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">← Kembali ke Pengaturan</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.routes.update') }}">
        @csrf

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Customizable Route Prefixes</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Atur prefix URL untuk setiap jenis konten. Kosongkan prefix untuk URL tanpa prefix (seperti WordPress).</p>

            <div class="space-y-6 max-w-2xl">

                {{-- Post --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Berita / Post</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="post-preview">/news/judul-berita</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_post_prefix" id="route_post_prefix"
                               value="{{ old('route_post_prefix', $routes['post']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="news"
                               oninput="document.getElementById('post-preview').textContent = '/' + (this.value || 'judul-berita')">
                        <span class="text-sm text-gray-500 dark:text-gray-400">/judul-berita</span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Kosongkan untuk: example.com/judul-berita</p>
                    @error('route_post_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Category --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="category-preview">/kategori/nama-kategori</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_category_prefix" id="route_category_prefix"
                               value="{{ old('route_category_prefix', $routes['category']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="kategori"
                               oninput="document.getElementById('category-preview').textContent = '/' + (this.value || 'nama-kategori')">
                        <span class="text-sm text-gray-500 dark:text-gray-400">/nama-kategori</span>
                    </div>
                    @error('route_category_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tag --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tag</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="tag-preview">/tag/nama-tag</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_tag_prefix" id="route_tag_prefix"
                               value="{{ old('route_tag_prefix', $routes['tag']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="tag"
                               oninput="document.getElementById('tag-preview').textContent = '/' + (this.value || 'nama-tag')">
                        <span class="text-sm text-gray-500 dark:text-gray-400">/nama-tag</span>
                    </div>
                    @error('route_tag_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Author --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Penulis</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="author-preview">/penulis/nama-penulis</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_author_prefix" id="route_author_prefix"
                               value="{{ old('route_author_prefix', $routes['author']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="penulis"
                               oninput="document.getElementById('author-preview').textContent = '/' + (this.value || 'nama-penulis')">
                        <span class="text-sm text-gray-500 dark:text-gray-400">/nama-penulis</span>
                    </div>
                    @error('route_author_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Page --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Halaman</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="page-preview">/page/nama-halaman</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_page_prefix" id="route_page_prefix"
                               value="{{ old('route_page_prefix', $routes['page']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="page"
                               oninput="document.getElementById('page-preview').textContent = '/' + (this.value || 'nama-halaman')">
                        <span class="text-sm text-gray-500 dark:text-gray-400">/nama-halaman</span>
                    </div>
                    @error('route_page_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Search --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Pencarian</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="search-preview">/pencarian?q=keyword</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_search_prefix" id="route_search_prefix"
                               value="{{ old('route_search_prefix', $routes['search']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="pencarian"
                               oninput="document.getElementById('search-preview').textContent = '/' + (this.value || 'search') + '?q=keyword'">
                        <span class="text-sm text-gray-500 dark:text-gray-400">?q=keyword</span>
                    </div>
                    @error('route_search_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Video --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Video</label>
                        <span class="text-xs text-gray-400 dark:text-gray-500" id="video-preview">/video</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="route_video_prefix" id="route_video_prefix"
                               value="{{ old('route_video_prefix', $routes['video']) }}"
                               class="w-40 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                               placeholder="video"
                               oninput="document.getElementById('video-preview').textContent = '/' + (this.value || 'videos')">
                    </div>
                    @error('route_video_prefix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mt-4">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <div>
                    <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Perlu Restart Server</p>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Setelah mengubah pengaturan route, restart server Laravel agar route baru berlaku: <code class="bg-yellow-100 dark:bg-yellow-900/50 px-1 rounded">php artisan serve</code></p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
