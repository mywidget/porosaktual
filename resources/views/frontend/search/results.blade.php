@extends('layouts.frontend')

@section('title', 'Hasil Pencarian: ' . request('q') . ' - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">Pencarian</span>
    </nav>

    {{-- Search Form --}}
    <div class="mb-8">
        <form action="{{ route('search.search') }}" method="GET" class="max-w-2xl">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita, artikel, topik..."
                       class="w-full pl-12 pr-24 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-lg">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-5 py-2 bg-blue-700 text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- Results Info --}}
    @if(request('q'))
        <p class="text-gray-500 dark:text-gray-400 mb-6">
            Menampilkan hasil untuk "<span class="font-semibold text-gray-700 dark:text-gray-300">{{ request('q') }}</span>"
            @if($posts ?? false)
                &middot; {{ $posts->total() }} hasil ditemukan
            @endif
        </p>
    @endif

    {{-- Results --}}
    @if(isset($posts) && $posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->appends(['q' => request('q')])->links() }}
        </div>
    @elseif(request('q'))
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Tidak ada hasil ditemukan</h2>
            <p class="text-gray-500 mb-6">Kami tidak menemukan artikel yang cocok dengan pencarian "{{ request('q') }}".</p>
            <div class="space-y-2 text-sm text-gray-500">
                <p>Saran:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Periksa ejaan kata kunci</li>
                    <li>Coba kata kunci yang lebih umum</li>
                    <li>Coba kata kunci yang berbeda</li>
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
