@extends('layouts.admin')

@section('title', 'Kelola Iklan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Iklan</h1>
        <a href="{{ route('admin.advertisements.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Iklan
        </a>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.advertisements.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pencarian</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul iklan..."
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipe</label>
                <select name="type" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Tipe</option>
                    <option value="banner" {{ request('type') === 'banner' ? 'selected' : '' }}>Banner</option>
                    <option value="html_script" {{ request('type') === 'html_script' ? 'selected' : '' }}>HTML Script</option>
                    <option value="adsense" {{ request('type') === 'adsense' ? 'selected' : '' }}>AdSense</option>
                    <option value="internal" {{ request('type') === 'internal' ? 'selected' : '' }}>Internal</option>
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                </select>
            </div>

            {{-- Date From --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Date To --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'type', 'status', 'date_from', 'date_to']))
                    <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">
                        Reset
                    </a>
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

    {{-- Results Info --}}
    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <span>Menampilkan {{ $advertisements->firstItem() ?? 0 }}-{{ $advertisements->lastItem() ?? 0 }} dari {{ $advertisements->total() }} iklan</span>
        @if(request()->hasAny(['search', 'type', 'status', 'date_from', 'date_to']))
            <span class="text-blue-600 dark:text-blue-400">{{ $advertisements->total() }} hasil ditemukan</span>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($advertisements as $ad)
                        @php
                            $isExpired = $ad->end_date && $ad->end_date->isPast();
                            $isScheduled = $ad->start_date && $ad->start_date->isFuture();
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ad->title }}</p>
                                    @if($ad->banner_image)
                                        <img src="{{ asset('storage/' . $ad->banner_image) }}" alt="" class="h-8 mt-1 rounded border border-gray-200 dark:border-gray-600">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded text-xs font-medium">{{ $ad->slot->name ?? '-' }}</span>
                                <span class="text-xs text-gray-400 block mt-0.5">{{ $ad->slot->location ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($ad->type === 'banner')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Banner</span>
                                @elseif($ad->type === 'html_script')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">HTML</span>
                                @elseif($ad->type === 'adsense')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">AdSense</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $ad->type }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col space-y-0.5">
                                    <span>Mulai: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $ad->start_date?->format('d M Y') ?? '-' }}</span></span>
                                    <span>Akhir: <span class="font-medium {{ $isExpired ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300' }}">{{ $ad->end_date?->format('d M Y') ?? '-' }}</span></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-1">
                                    <form method="POST" action="{{ route('admin.advertisements.toggle', $ad) }}">
                                        @csrf
                                        <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $ad->is_active ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-600' }}">
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $ad->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                    </form>
                                    @if($isExpired)
                                        <span class="text-xs text-red-600 dark:text-red-400 font-medium">Kadaluarsa</span>
                                    @elseif($isScheduled)
                                        <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Terjadwal</span>
                                    @elseif($ad->is_active)
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">Aktif</span>
                                    @else
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Nonaktif</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.advertisements.edit', $ad) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.advertisements.destroy', $ad) }}" onsubmit="return confirm('Yakin ingin menghapus iklan ini?')">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada iklan ditemukan</p>
                                @if(request()->hasAny(['search', 'type', 'status', 'date_from', 'date_to']))
                                    <a href="{{ route('admin.advertisements.index') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Reset Filter</a>
                                @else
                                    <a href="{{ route('admin.advertisements.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Tambah Iklan</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($advertisements) && $advertisements->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $advertisements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
