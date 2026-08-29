@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Media Library</h1>
        <div class="flex items-center space-x-3">
            <form id="media-upload-form" action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" name="file" id="media-upload-input" accept="image/*">
            </form>
            <button type="button" onclick="document.getElementById('media-upload-input').click()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Upload
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6" x-data="mediaManager()">
        {{-- Dropzone --}}
        <div id="media-dropzone" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-blue-400 transition mb-6"
             @dragover.prevent="$el.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10')"
             @dragleave.prevent="$el.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10')"
             @drop.prevent="handleDrop($event)">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Drag & drop gambar ke sini atau <span class="text-blue-600 dark:text-blue-400 font-medium">browse</span></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF, WEBP (Maks. 5MB)</p>
        </div>

        {{-- Upload Progress --}}
        <div x-show="uploading" x-transition class="mb-4">
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Mengunggah... <span x-text="progress"></span>%</p>
        </div>

        <div class="flex items-center justify-between mb-4">
            <span class="text-sm text-gray-600 dark:text-gray-300">Total: {{ $media->total() }} file</span>
            <button x-show="selected.length > 0" @click="deleteSelected()" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus (<span x-text="selected.length"></span>)
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($media as $item)
                <div class="relative group cursor-pointer rounded-lg overflow-hidden border-2 transition"
                     :class="selected.includes({{ $item->id }}) ? 'border-blue-500' : 'border-transparent hover:border-gray-200 dark:hover:border-gray-600'"
                     @click="selected.includes({{ $item->id }}) ? selected = selected.filter(i => i !== {{ $item->id }}) : selected.push({{ $item->id }})">
                    <div class="aspect-square bg-gray-100 dark:bg-gray-700">
                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex items-center space-x-2">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="p-2 bg-white/90 dark:bg-gray-800/90 rounded-full text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700 transition" onclick="event.stopPropagation()">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button type="button" @click.stop="copyUrl('{{ asset('storage/' . $item->file_path) }}')" class="p-2 bg-white/90 dark:bg-gray-800/90 rounded-full text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus file ini?')" onclick="event.stopPropagation()">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/90 text-white rounded-full hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-2">
                        <p class="text-xs text-gray-600 dark:text-gray-300 truncate">{{ $item->file_name }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $item->file_size ? number_format($item->file_size / 1024, 1) . ' KB' : '-' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada file media</p>
                </div>
            @endforelse
        </div>

        @if(isset($media) && $media->hasPages())
            <div class="mt-6">
                {{ $media->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function mediaManager() {
        return {
            selected: [],
            uploading: false,
            progress: 0,

            handleDrop(e) {
                const dropzone = document.getElementById('media-dropzone');
                dropzone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    this.uploadFile(files[0]);
                }
            },

            uploadFile(file) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                this.uploading = true;
                this.progress = 0;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("admin.media.store") }}', true);

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        this.progress = Math.round((e.loaded / e.total) * 100);
                    }
                };

                xhr.onload = () => {
                    this.uploading = false;
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        alert('Upload gagal. Silakan coba lagi.');
                    }
                };

                xhr.onerror = () => {
                    this.uploading = false;
                    alert('Upload gagal. Silakan coba lagi.');
                };

                xhr.send(formData);
            },

            copyUrl(url) {
                navigator.clipboard.writeText(url).then(() => {
                    alert('URL berhasil disalin!');
                });
            },

            deleteSelected() {
                if (!confirm(`Hapus ${this.selected.length} file yang dipilih?`)) return;
                this.selected.forEach(id => {
                    fetch(`/admin/media/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                });
                setTimeout(() => location.reload(), 500);
            }
        }
    }

    document.getElementById('media-upload-input').addEventListener('change', function() {
        if (this.files.length > 0) {
            const form = document.getElementById('media-upload-form');
            const formData = new FormData(form);
            fetch(form.action, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => { if (data.success) location.reload(); })
                .catch(() => location.reload());
        }
    });
</script>
@endpush
@endsection
