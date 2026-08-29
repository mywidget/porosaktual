@extends('layouts.admin')

@section('title', 'Tambah Iklan')

@section('content')
<form method="POST" action="{{ route('admin.advertisements.store') }}" enctype="multipart/form-data" x-data="adForm()">
    @csrf

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Iklan</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Batal</a>
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
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Iklan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="slot_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slot Iklan <span class="text-red-500">*</span></label>
                        <select name="slot_id" id="slot_id" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Slot</option>
                            @foreach($slots ?? [] as $slot)
                                <option value="{{ $slot->id }}" {{ old('slot_id') == $slot->id ? 'selected' : '' }}>{{ $slot->name }} ({{ $slot->size ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Judul iklan">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe <span class="text-red-500">*</span></label>
                        <select name="type" id="type" x-model="type" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="adsense" {{ old('type') === 'adsense' ? 'selected' : '' }}>Google AdSense</option>
                            <option value="banner" {{ old('type') === 'banner' ? 'selected' : '' }}>Banner</option>
                            <option value="html_script" {{ old('type') === 'html_script' ? 'selected' : '' }}>HTML Script</option>
                            <option value="internal" {{ old('type') === 'internal' ? 'selected' : '' }}>Internal</option>
                        </select>
                    </div>

                    <div x-show="type === 'banner'" x-transition>
                        <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gambar Banner</label>
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: PNG, JPG, WEBP. Ukuran optimal sesuai dimensi slot.</p>
                    </div>

                    <div x-show="type === 'html_script'" x-transition>
                        <label for="html_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode HTML</label>
                        <textarea name="html_code" id="html_code" rows="8" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm" placeholder="Masukkan kode HTML/JavaScript iklan">{{ old('html_code') }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Masukkan kode iklan HTML, JavaScript, atau iframe.</p>
                    </div>

                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL Tujuan</label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://...">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">URL tujuan saat iklan diklik (opsional untuk AdSense).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h2>

                <div class="space-y-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kosongkan jika tidak ada batas waktu.</p>
                    </div>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">Simpan Iklan</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function adForm() {
        return {
            type: '{{ old("type", "adsense") }}'
        }
    }
</script>
@endpush
@endsection
