<!DOCTYPE html>
<html lang="id" x-data="darkMode" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($settings['site_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    @endif
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1C1917">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(app()->environment('production'))
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.9/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @endif
    @stack('meta')
    <title>@yield('title', config('app.name', 'Poros Aktual'))</title>
    <style>
        [x-cloak] { display: none !important; }
        .magazine-border { border: 2px solid #D97706; }
        .magazine-divider { border-top: 3px solid #D97706; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => ({
                dark: localStorage.getItem('dark') === 'true' || (!localStorage.getItem('dark') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toggle() { this.dark = !this.dark; localStorage.setItem('dark', this.dark); }
            }));
        });
    </script>
</head>
<body class="bg-stone-100 dark:bg-stone-900 text-stone-800 dark:text-stone-200 font-serif antialiased min-h-screen flex flex-col">

    {{-- Top Bar --}}
    <div class="bg-stone-900 dark:bg-black text-stone-300 text-xs py-1.5">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                @if(!empty($settings['site_email']))
                    <span class="hidden sm:inline">{{ $settings['site_email'] }}</span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline hover:text-amber-400 transition">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline hover:text-amber-400 transition">Masuk</a>
                @endauth
                <button @click="toggle()" class="hidden sm:inline hover:text-amber-400 transition">
                    <template x-if="!dark">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                </button>
            </div>
        </div>
    </div>

    {{-- Masthead --}}
    <header class="bg-white dark:bg-stone-800 border-b-4 border-amber-600" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 py-4 md:py-6">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex-1">
                    @if(!empty($settings['site_logo']))
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? config('app.name') }}" class="h-10 md:h-12">
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="text-2xl md:text-4xl font-bold tracking-tight text-stone-900 dark:text-white uppercase">
                            {{ $settings['site_name'] ?? config('app.name') }}
                        </a>
                    @endif
                </div>

                {{-- Hamburger Menu (Mobile) --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-stone-700 dark:text-stone-300 hover:text-amber-600 transition">
                    <svg x-show="!mobileMenu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium hover:bg-stone-700 hover:text-amber-400 rounded transition uppercase tracking-wider">Home</a>
                    @foreach($headerMenus as $item)
                        <a href="{{ $item->url ?: ($item->post ? post_url($item->post) : '#') }}"
                           class="px-3 py-2 text-sm font-medium hover:bg-stone-700 hover:text-amber-400 rounded transition uppercase tracking-wider">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div x-show="mobileMenu" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white dark:bg-stone-800 border-t border-stone-200 dark:border-stone-700 shadow-lg">
            <div class="px-4 py-3 space-y-1">
                {{-- Search --}}
                <form action="{{ route('search.search') }}" method="GET" class="mb-3">
                    <div class="flex">
                        <input type="text" name="q" placeholder="Cari berita..." class="flex-1 px-3 py-2 text-sm border border-stone-300 dark:border-stone-600 dark:bg-stone-700 dark:text-white rounded-l focus:outline-none focus:border-amber-500">
                        <button type="submit" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-r transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>

                {{-- Dark Mode Toggle --}}
                <button @click="toggle()" class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">
                    <template x-if="!dark">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                    <template x-if="dark">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <span x-text="dark ? 'Mode Terang' : 'Mode Gelap'"></span>
                </button>

                <div class="border-t border-stone-200 dark:border-stone-700 my-2"></div>

                {{-- Auth Links --}}
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">Masuk</a>
                @endauth

                <div class="border-t border-stone-200 dark:border-stone-700 my-2"></div>

                {{-- Menu Links --}}
                <a href="{{ route('home') }}" class="block px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">Home</a>
                @foreach($headerMenus as $item)
                    <a href="{{ $item->url ?: ($item->post ? post_url($item->post) : '#') }}" class="block px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">{{ $item->name }}</a>
                @endforeach

                <div class="border-t border-stone-200 dark:border-stone-700 my-2"></div>

                {{-- Categories --}}
                @foreach($categories as $cat)
                    <a href="{{ category_url($cat) }}" class="block px-3 py-2.5 text-sm font-medium rounded hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-stone-700 transition">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </header>

    {{-- Category Bar (Desktop) --}}
    <nav class="hidden md:block bg-stone-800 dark:bg-stone-950 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center h-11 overflow-x-auto">
                @foreach($categories as $cat)
                    <a href="{{ category_url($cat) }}" class="flex-shrink-0 px-3 py-2 text-xs font-medium bg-amber-600 hover:bg-amber-700 text-white rounded transition uppercase tracking-wider">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- Breaking News --}}
    @if(isset($breakingNewsItems) && $breakingNewsItems->count())
    <div class="bg-red-700 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 flex items-center">
            <span class="bg-red-900 px-3 py-1.5 text-xs font-bold uppercase tracking-wider flex-shrink-0">Breaking</span>
            <div class="overflow-hidden ml-3">
                <div class="animate-marquee whitespace-nowrap py-1.5">
                    @foreach($breakingNewsItems as $item)
                        <a href="{{ $item->url ?: ($item->post ? post_url($item->post) : '#') }}" class="inline-block mx-6 text-sm hover:underline">
                            {{ $item->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-stone-900 dark:bg-black text-stone-400 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    @if(!empty($settings['site_footer_logo']))
                        <img src="{{ asset('storage/' . $settings['site_footer_logo']) }}" alt="Logo" class="h-8 mb-3">
                    @else
                        <h3 class="text-xl font-bold text-white uppercase tracking-wider mb-3">{{ $settings['site_name'] ?? config('app.name') }}</h3>
                    @endif
                    <p class="text-sm leading-relaxed">{{ $settings['site_description'] ?? '' }}</p>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-3 magazine-border inline-block pb-1">Kategori</h4>
                    <ul class="space-y-1.5 text-sm">
                        @foreach($categories->take(6) as $cat)
                            <li><a href="{{ category_url($cat) }}" class="hover:text-amber-400 transition">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-3 magazine-border inline-block pb-1">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        @if(!empty($settings['social_facebook']))
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-blue-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_twitter']))
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-sky-500 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_instagram']))
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-pink-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_youtube']))
                            <a href="{{ $settings['social_youtube'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-red-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_tiktok']))
                            <a href="{{ $settings['social_tiktok'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-stone-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="border-t border-stone-700 mt-8 pt-6 text-center text-xs text-stone-500">
                &copy; {{ date('Y') }} {{ $settings['site_name'] ?? config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
