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
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-amber-400 transition">Masuk</a>
                @endauth
                <button @click="toggle()" class="hover:text-amber-400 transition">
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
    <header class="bg-white dark:bg-stone-800 border-b-4 border-amber-600">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            @if(!empty($settings['site_logo']))
                <a href="{{ route('home') }}">
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? config('app.name') }}" class="h-12 mx-auto">
                </a>
            @else
                <a href="{{ route('home') }}" class="text-3xl md:text-4xl font-bold tracking-tight text-stone-900 dark:text-white uppercase">
                    {{ $settings['site_name'] ?? config('app.name') }}
                </a>
            @endif
            <p class="text-stone-500 dark:text-stone-400 text-sm mt-1 italic">{{ $settings['site_description'] ?? '' }}</p>
        </div>
    </header>

    {{-- Navigation --}}
    <nav class="bg-stone-800 dark:bg-stone-950 text-white sticky top-0 z-50 shadow-lg" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-11">
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium hover:bg-stone-700 rounded transition uppercase tracking-wider">Home</a>
                    @foreach($headerMenus as $item)
                        <a href="{{ $item->url ?: ($item->post ? post_url($item->post) : '#') }}"
                           class="px-3 py-2 text-sm font-medium hover:bg-stone-700 rounded transition uppercase tracking-wider">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
                <div class="flex items-center gap-2">
                    @foreach($categories as $cat)
                        @if($loop->index < 5)
                            <a href="{{ category_url($cat) }}" class="hidden lg:inline-block px-2 py-1 text-xs bg-amber-600 hover:bg-amber-700 text-white rounded transition uppercase tracking-wider">{{ $cat->name }}</a>
                        @endif
                    @endforeach
                </div>
                <button @click="open = !open" class="md:hidden p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <div x-show="open" x-transition class="md:hidden bg-stone-700 border-t border-stone-600">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-sm rounded hover:bg-stone-600">Home</a>
                @foreach($headerMenus as $item)
                    <a href="{{ $item->url ?: ($item->post ? post_url($item->post) : '#') }}" class="block px-3 py-2 text-sm rounded hover:bg-stone-600">{{ $item->name }}</a>
                @endforeach
                @foreach($categories as $cat)
                    <a href="{{ category_url($cat) }}" class="block px-3 py-2 text-sm rounded hover:bg-stone-600">{{ $cat->name }}</a>
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
                        @if(!empty($settings['facebook_url']))
                            <a href="{{ $settings['facebook_url'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-blue-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['twitter_url']))
                            <a href="{{ $settings['twitter_url'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-sky-500 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['instagram_url']))
                            <a href="{{ $settings['instagram_url'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-pink-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['youtube_url']))
                            <a href="{{ $settings['youtube_url'] }}" target="_blank" class="w-9 h-9 bg-stone-700 hover:bg-red-600 rounded-full flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
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
