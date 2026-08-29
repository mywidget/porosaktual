@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Berita</h1>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Berita
        </a>
    </div>

    <form method="GET" action="{{ route('admin.posts.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pencarian</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                           class="w-full pl-10 pr-3 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kategori</label>
                <select name="category_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Filter</button>
                @if(request()->hasAny(['search', 'status', 'category_id', 'date_from', 'date_to']))
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Reset</a>
                @endif
            </div>
            <div class="flex items-center space-x-3">
                <label class="text-sm text-gray-600 dark:text-gray-400">Tampilkan:</label>
                <select name="limit" onchange="this.form.submit()" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach([10, 20, 50, 100] as $l)
                        <option value="{{ $l }}" {{ request('limit', 20) == $l ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-gray-500 dark:text-gray-400">data</span>
            </div>
        </div>
    </form>

    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <span>Menampilkan {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} dari {{ $posts->total() }} berita</span>
    </div>

    <form id="bulk-action-form" method="POST" action="{{ route('admin.posts.bulk-action') }}">
        @csrf
        <input type="hidden" name="action" id="bulk-action-input">
        <input type="hidden" name="post_ids[]" id="bulk-ids-input">

        <div id="bulk-actions-bar" class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-300"><span id="selected-count">0</span> berita dipilih</span>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="setBulkAction('publish')" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">Publish</button>
                    <button type="button" onclick="setBulkAction('draft')" class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition">Draft</button>
                    <button type="button" onclick="setBulkAction('delete')" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox" id="select-all" class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Berita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Diterbitkan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-4 py-4"><input type="checkbox" name="post_ids[]" value="{{ $post->id }}" class="post-checkbox rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500"></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex-shrink-0 overflow-hidden">
                                        @if($post->featured_image)
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="h-12 w-16 object-cover" alt="">
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 max-w-xs truncate block">{{ $post->title }}</a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ Str::limit($post->excerpt, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $post->author->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $post->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($post->status === 'published')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Published</span>
                                @elseif($post->status === 'draft')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Draft</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Scheduled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ number_format($post->views_count ?? 0) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $post->published_at ? $post->published_at->format('d M Y H:i') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($post->status !== 'published')
                                        <form method="POST" action="{{ route('admin.posts.publish', $post) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition" title="Publish">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada berita ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($posts) && $posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.post-checkbox');
    const bulkBar = document.getElementById('bulk-actions-bar');
    const countSpan = document.getElementById('selected-count');
    const idsInput = document.getElementById('bulk-ids-input');
    const actionInput = document.getElementById('bulk-action-input');

    selectAll?.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBulkBar();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

    function updateBulkBar() {
        const checked = document.querySelectorAll('.post-checkbox:checked');
        countSpan.textContent = checked.length;
        bulkBar.classList.toggle('hidden', checked.length === 0);
        idsInput.value = Array.from(checked).map(cb => cb.value).join(',');
    }

    function setBulkAction(action) {
        if (!confirm(action === 'delete' ? 'Yakin ingin menghapus berita yang dipilih?' : 'Lanjutkan aksi ini?')) return;
        actionInput.value = action;
        document.getElementById('bulk-action-form').submit();
    }
</script>
@endpush
@endsection
