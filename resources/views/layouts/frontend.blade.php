<!DOCTYPE html>
<html lang="id" x-data="darkMode" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['site_favicon']) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @else
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    @endif
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#013F99">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Poros Aktual">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(app()->environment('production'))
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.9/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @endif
    @stack('meta')
    <title>@yield('title', config('app.name', 'Poros Aktual'))</title>
    <style>
        [x-cloak] { display: none !important; }
        .ticker-wrap {
            display: flex;
            width: max-content;
        }
        .animate-ticker {
            animation: ticker-scroll 20s linear infinite;
        }
        .group:hover .animate-ticker {
            animation-play-state: paused;
        }
        @keyframes ticker-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</head>
<body class="dark:bg-gray-900 dark:text-gray-100 bg-white text-gray-900 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? 'Poros Aktual' }}" class="h-10">
                    @else
                        <span class="text-2xl font-extrabold tracking-tight">
                            <span class="text-blue-700">Poros</span>
                            <span class="text-red-600">Aktual</span>
                        </span>
                    @endif
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center space-x-1 flex-1 justify-center">
                    @foreach($headerMenus as $menu)
                        @if($menu->children->count())
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" @click.away="open = false"
                                        class="flex items-center space-x-1 px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                    <span>{{ $menu->name }}</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-cloak x-transition
                                     class="absolute left-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50 border border-gray-100 dark:border-gray-700">
                                    <a href="{{ $menu->url }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 transition">{{ $menu->name }}</a>
                                    @foreach($menu->children->where('is_active', true) as $child)
                                        <a href="{{ $child->url }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-blue-50 dark:hover:bg-gray-700 transition"
                                           @if($child->target === '_blank') target="_blank" @endif>
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}"
                               class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-50 dark:hover:bg-gray-700 transition"
                               @if($menu->target === '_blank') target="_blank" @endif>
                                {{ $menu->name }}
                            </a>
                        @endif
                    @endforeach
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center space-x-2 ml-auto">
                    {{-- Search --}}
                    <button @click="searchOpen = !searchOpen" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition" aria-label="Cari">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    {{-- Dark Mode Toggle --}}
                    <button @click="toggle()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition" aria-label="Toggle dark mode">
                        <template x-if="!dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.005 9.005 0 0012 21a9.005 9.005 0 008.354-5.646z"/></svg>
                        </template>
                        <template x-if="dark">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </template>
                    </button>

                    {{-- Auth --}}
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-1 px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="" class="w-6 h-6 rounded-full">
                                <span class="hidden sm:inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-50">
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">Admin Panel</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition" aria-label="Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden border-t dark:border-gray-700 bg-white dark:bg-gray-800 max-h-[70vh] overflow-y-auto">
            <div class="px-4 py-3 space-y-1">
                @foreach($headerMenus as $menu)
                    @if($menu->children->count())
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span>{{ $menu->name }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-cloak x-collapse class="ml-4 space-y-1">
                                <a href="{{ $menu->url }}" class="block px-3 py-1.5 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">{{ $menu->name }}</a>
                                @foreach($menu->children->where('is_active', true) as $child)
                                    <a href="{{ $child->url }}" class="block px-3 py-1.5 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                                       @if($child->target === '_blank') target="_blank" @endif>
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->url }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
                           @if($menu->target === '_blank') target="_blank" @endif>
                            {{ $menu->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </header>

    {{-- Search Modal --}}
    <div x-show="searchOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[60] bg-black/50 flex items-start justify-center pt-24 px-4" @click.self="searchOpen = false" @keydown.escape.window="searchOpen = false">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl p-4 sm:p-6" @click.stop>
            <form action="{{ route('search.search') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="flex items-center flex-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita, artikel, topik..."
                           class="flex-1 bg-transparent border-none outline-none text-base sm:text-lg placeholder-gray-400 dark:text-white ml-3" autofocus>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-700 text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition">Cari</button>
            </form>
        </div>
    </div>

    {{-- Breaking News Ticker --}}
    @php
        $tickerItems = $breakingNewsItems->map(fn($item) => [
            'title' => $item->title,
            'url' => $item->url ?? ($item->post ? route('post.show', $item->post->slug) : '#'),
        ])->toArray();
    @endphp
    <div class="bg-red-600 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center h-10">
            <div class="flex-shrink-0 px-4 py-2 bg-red-700 font-bold text-xs uppercase tracking-wider flex items-center space-x-1 h-full">
                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/></svg>
                <span>Breaking News</span>
            </div>
            <div class="flex-1 overflow-hidden relative h-full flex items-center group">
                @if(count($tickerItems) > 0)
                    <div class="ticker-wrap flex items-center whitespace-nowrap animate-ticker"
                         style="--ticker-count: {{ count($tickerItems) }}">
                        @foreach($tickerItems as $item)
                            <a href="{{ $item['url'] }}" class="inline-flex items-center px-6 text-sm font-medium hover:underline">
                                <span class="w-1.5 h-1.5 bg-white rounded-full mr-3 flex-shrink-0"></span>
                                {{ $item['title'] }}
                            </a>
                        @endforeach
                        @foreach($tickerItems as $item)
                            <a href="{{ $item['url'] }}" class="inline-flex items-center px-6 text-sm font-medium hover:underline">
                                <span class="w-1.5 h-1.5 bg-white rounded-full mr-3 flex-shrink-0"></span>
                                {{ $item['title'] }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <span class="px-4 text-sm">Selamat datang di Poros Aktual - Portal Berita Terpercaya</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Before Footer Ad --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <x-ad-slot location="footer" />
    </div>

    {{-- Footer --}}
    <footer style="background-color: #013F99" class="text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                {{-- Brand --}}
                <div>
                    @if(!empty($settings['site_footer_logo']))
                        <img src="{{ asset('storage/' . $settings['site_footer_logo']) }}" alt="{{ $settings['site_name'] ?? 'Poros Aktual' }}" class="h-10 mb-3">
                    @else
                        <span class="text-2xl font-extrabold">
                            <span class="text-white">Poros</span>
                            <span class="text-red-400">Aktual</span>
                        </span>
                    @endif
                    <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                        Portal berita terpercaya dengan informasi terkini dari Indonesia dan dunia.
                    </p>
                </div>

                {{-- Footer Menus (no sub-menus) --}}
                @foreach($footerMenus->whereNull('parent_id')->groupBy('location') as $location => $menus)
                    <div>
                        <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                            @if($location === 'header') Navigasi
                            @elseif($location === 'footer') Info
                            @elseif($location === 'sidebar') Lainnya
                            @else {{ $location }} @endif
                        </h3>
                        <ul class="space-y-2 text-sm">
                            @foreach($menus as $menu)
                                <li>
                                    <a href="{{ $menu->url }}" class="hover:text-white transition"
                                       @if($menu->target === '_blank') target="_blank" @endif>{{ $menu->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                {{-- Hubungi Kami --}}
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('page.show', 'kontak') }}" class="hover:text-white transition">Kontak & Beriklan</a></li>
                    </ul>
                    <div class="flex items-center space-x-3 mt-4">
                        <a href="#" class="hover:text-white transition" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="hover:text-white transition" aria-label="Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="hover:text-white transition" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="hover:text-white transition" aria-label="YouTube">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="mt-10 pt-8 border-t border-blue-800 text-center text-sm text-gray-300">
                {!! $settings['site_footer'] ?? '&copy; ' . date('Y') . ' ' . config('app.name', 'Poros Aktual') . '. All rights reserved.' !!}
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => ({
                dark: localStorage.getItem('darkMode') === 'true',
                mobileMenu: false,
                searchOpen: false,
                toggle() {
                    this.dark = !this.dark;
                    localStorage.setItem('darkMode', this.dark);
                }
            }));
        });
    </script>

    {{-- PWA Service Worker + Install Banner --}}
    <div x-data="pwaInstall()" x-cloak>
        {{-- Floating Install Button --}}
        <button x-show="canInstall && !showBanner" x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="scale-0 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                @click="showBanner = true"
                class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center group"
                style="background-color:#013F99;color:#fff"
                title="Pasang Poros Aktual">
            <svg style="color:#fff" class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
        </button>

        {{-- Install Banner --}}
        <div x-show="showBanner" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-0 left-0 right-0 z-50 p-4">
            <div class="max-w-lg mx-auto rounded-xl shadow-2xl p-4 flex items-center space-x-4" style="background-color:#fff;border:1px solid #e5e7eb">
                <img src="{{ asset('images/android-chrome-192x192.png') }}" alt="Poros Aktual" class="w-12 h-12 rounded-lg flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm" style="color:#111827">Pasang Poros Aktual</p>
                    <p class="text-xs truncate" style="color:#6b7280">Akses berita lebih cepat &amp; membaca offline</p>
                </div>
                <button @click="install()" class="px-4 py-2 text-sm font-medium rounded-lg transition flex-shrink-0" style="background-color:#013F99;color:#fff">Pasang</button>
                <button @click="dismissBanner()" class="p-1 transition flex-shrink-0" style="color:#9ca3af">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }

        function pwaInstall() {
            return {
                canInstall: false,
                showBanner: false,
                deferredPrompt: null,
                init() {
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this.deferredPrompt = e;
                        if (!localStorage.getItem('pwa_dismissed')) {
                            this.canInstall = true;
                            this.showBanner = true;
                        }
                    });
                    window.addEventListener('appinstalled', () => {
                        this.canInstall = false;
                        this.showBanner = false;
                        this.deferredPrompt = null;
                    });
                },
                async install() {
                    if (!this.deferredPrompt) return;
                    this.deferredPrompt.prompt();
                    const { outcome } = await this.deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        this.canInstall = false;
                        this.showBanner = false;
                    }
                    this.deferredPrompt = null;
                },
                dismissBanner() {
                    this.showBanner = false;
                    localStorage.setItem('pwa_dismissed', 'true');
                },
                dismiss() {
                    this.canInstall = false;
                    this.showBanner = false;
                    localStorage.setItem('pwa_dismissed', 'true');
                }
            };
        }
    </script>

    @stack('scripts')
</body>
</html>
