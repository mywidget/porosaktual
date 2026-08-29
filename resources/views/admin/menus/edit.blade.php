@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Menu</h1>
        <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Kembali</a>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <ul class="text-sm text-red-700 dark:text-red-400 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL <span class="text-red-500">*</span></label>
                <input type="text" name="url" value="{{ old('url', $menu->url) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi</label>
                <select name="location" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="header" {{ old('location', $menu->location) === 'header' ? 'selected' : '' }}>Header</option>
                    <option value="footer" {{ old('location', $menu->location) === 'footer' ? 'selected' : '' }}>Footer</option>
                    <option value="sidebar" {{ old('location', $menu->location) === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parent</label>
                <select name="parent_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tidak ada (Item Utama)</option>
                    @foreach($parentMenus as $item)
                        <option value="{{ $item->id }}" {{ old('parent_id', $menu->parent_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target</label>
                <select name="target" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="_self" {{ old('target', $menu->target) === '_self' ? 'selected' : '' }}>Same Tab</option>
                    <option value="_blank" {{ old('target', $menu->target) === '_blank' ? 'selected' : '' }}>New Tab</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $menu->icon) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="heroicon (opsional)">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $menu->sort_order) }}" min="0" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
            </label>

            <div class="flex items-center justify-end space-x-3 pt-4">
                <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
