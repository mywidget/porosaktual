@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kategori</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
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
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Kategori</h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nama kategori" x-data="{ name: '{{ old("name", $category->name) }}' }" x-init="$watch('name', val => $refs.slugInput.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''))">
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="slug" x-ref="slugInput" value="{{ old('slug', $category->slug) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="slug-kategori">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi kategori (opsional)">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SEO</h2>

                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Judul untuk SEO">
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi untuk SEO">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="keyword1, keyword2, keyword3">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pisahkan dengan koma</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Induk</label>
                        <select name="parent_id" id="parent_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tidak ada (Kategori Utama)</option>
                            @foreach($categories ?? [] as $cat)
                                @if($cat->id !== $category->id)
                                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutan</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gambar</label>
                        @if($category->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Current image" class="w-full h-32 object-cover rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400 hover:file:bg-blue-100">
                    </div>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">Perbarui Kategori</button>
        </div>
    </div>
</form>
@endsection
