@extends('layouts.frontend')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . config('app.name'))

@push('meta')
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-blue-700 transition">Home</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">{{ $page->title }}</span>
    </nav>

    {{-- Page Content --}}
    <article>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-8 leading-tight">{{ $page->title }}</h1>

        <div class="prose prose-lg dark:prose-invert max-w-none">
            {!! $page->content !!}
        </div>
    </article>

    {{-- Last Updated --}}
    @if($page->updated_at)
        <div class="mt-10 pt-6 border-t text-sm text-gray-500">
            Terakhir diperbarui: {{ $page->updated_at->format('d F Y, H:i') }} WIB
        </div>
    @endif
</div>
@endsection
