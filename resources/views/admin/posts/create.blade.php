@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" x-data="postForm()">
    @csrf

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Berita</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Simpan</button>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="text-sm font-medium text-red-800 dark:text-red-300">Terdapat kesalahan:</p>
                    <ul class="mt-1 text-sm text-red-700 dark:text-red-400 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konten Utama</h2>

                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" x-model="title" @input="generateSlug()" value="{{ old('title') }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan judul berita">
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="slug" x-model="slug" value="{{ old('slug') }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="slug-berita">
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Excerpt</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ringkasan singkat berita">{{ old('excerpt') }}</textarea>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konten <span class="text-red-500">*</span></label>
                        <input type="hidden" name="content" id="contentInput">
                        <div id="editor" class="bg-white dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 h-96" style="min-height: 400px;"></div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Gunakan editor di atas untuk menulis konten berita dengan format yang lebih kaya</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SEO</h2>

                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Judul untuk SEO">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kosongkan untuk menggunakan judul default</p>
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi untuk SEO">{{ old('meta_description') }}</textarea>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="keyword1, keyword2, keyword3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pisahkan dengan koma</p>
                    </div>

                    <div>
                        <label for="og_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">OG Image</label>
                        <input type="file" name="og_image" id="og_image" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Penerbitan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" x-model="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                    </div>

                    <div x-show="status === 'scheduled'" x-transition>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jadwalkan Pada</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                        <select id="tags-select" name="tags[]" multiple class="w-full">
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Gambar Utama</h2>

                <div class="space-y-3">
                    <div x-show="!imagePreview" class="space-y-2">
                        <button type="button" @click="openGallery = true" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                            Pilih dari Gallery
                        </button>
                        <div class="text-center text-xs text-gray-500 dark:text-gray-400">atau</div>
                    </div>
                    <label for="featured_image" class="block">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <span>Upload gambar</span>
                                    <input type="file" name="featured_image" id="featured_image" accept="image/*" class="sr-only" @change="previewImage($event)">
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP (Maks. 2MB)</p>
                            </div>
                        </div>
                    </label>
                    <div x-show="imagePreview" class="space-y-2">
                        <img :src="imagePreview" class="w-full h-40 object-cover rounded-lg" alt="Preview">
                        <button type="button" @click="clearImage()" class="w-full px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition">
                            Hapus Gambar
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Opsi Tambahan</h2>

                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Trending</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_breaking" value="1" {{ old('is_breaking') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Breaking News</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_highlight" value="1" {{ old('is_highlight') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Highlight</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_sponsored" value="1" {{ old('is_sponsored') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sponsored</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">Simpan Berita</button>
        </div>
    </div>

    <!-- Media Gallery Modal -->
    <div x-show="openGallery" x-cloak @click.outside="openGallery = false" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-4xl w-full max-h-96 overflow-hidden flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Gambar dari Gallery</h3>
                <button type="button" @click="openGallery = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @forelse(\App\Models\Media::latest()->limit(50)->get() as $media)
                        <button type="button" @click="selectGalleryImage('{{ asset('storage/' . $media->file_path) }}')" class="relative group rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-500 transition">
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->alt_text }}" class="w-full h-24 object-cover">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                                <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </button>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada gambar di gallery</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function postForm() {
        return {
            title: '{{ old("title") }}',
            slug: '{{ old("slug") }}',
            status: '{{ old("status", "draft") }}',
            imagePreview: null,
            openGallery: false,
            quill: null,

            init() {
                this.$nextTick(() => {
                    this.quill = new Quill('#editor', {
                        theme: 'snow',
                        placeholder: 'Tulis konten berita di sini...',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'align': [] }],
                                [{ 'color': [] }, { 'background': [] }],
                                ['link', 'image', 'video'],
                                ['clean']
                            ]
                        }
                    });

                    const content = @json(old('content'));
                    if (content) {
                        this.quill.root.innerHTML = content;
                    }

                    this.quill.on('text-change', () => {
                        document.getElementById('contentInput').value = this.quill.root.innerHTML;
                    });

                    document.getElementById('contentInput').value = this.quill.root.innerHTML;
                });
            },

            generateSlug() {
                this.slug = this.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            },

            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    this.imagePreview = URL.createObjectURL(file);
                }
            },

            clearImage() {
                this.imagePreview = null;
                document.getElementById('featured_image').value = '';
            },

            selectGalleryImage(url) {
                // Create a fake file for the file input
                fetch(url)
                    .then(res => res.blob())
                    .then(blob => {
                        const fileName = url.split('/').pop();
                        const file = new File([blob], fileName, { type: blob.type });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('featured_image').files = dataTransfer.files;
                        this.imagePreview = url;
                        this.openGallery = false;
                    });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        $('#tags-select').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: 'Ketik nama tag, pisahkan dengan koma',
            ajax: {
                url: '{{ route("admin.tags.search") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { q: params.term };
                },
                processResults: function(data) {
                    return { results: data };
                }
            },
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            }
        });

        $('#tags-select').on('select2:selecting', function(e) {
            if (e.params.args.data.newTag) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("admin.tags.storeAjax") }}',
                    type: 'POST',
                    data: {
                        name: e.params.args.data.text,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var option = new Option(response.name, response.id, true, true);
                        $('#tags-select').append(option).trigger('change');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
