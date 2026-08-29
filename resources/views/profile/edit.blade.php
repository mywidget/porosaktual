<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Berita yang Pernah Dikomentari</h3>
                <div class="space-y-4">
                    @php
                        $commentedPosts = auth()->user()->comments()
                            ->where('status', 'approved')
                            ->with('post')
                            ->distinct('post_id')
                            ->orderByDesc('created_at')
                            ->limit(10)
                            ->get()
                            ->pluck('post')
                            ->unique('id');
                    @endphp

                    @forelse($commentedPosts as $post)
                        <a href="{{ route('post.show', $post->slug) }}" class="block p-4 border border-gray-200 rounded-lg hover:shadow-md hover:border-blue-300 transition">
                            <div class="flex gap-4">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 truncate hover:text-blue-600">{{ $post->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $post->created_at->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 100) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center text-gray-500 py-8">Belum ada berita yang Anda komentari</p>
                    @endforelse

                    @if($commentedPosts->count() > 0)
                        <a href="{{ route('home') }}" class="block text-center text-blue-600 hover:text-blue-800 mt-4 text-sm font-medium">
                            Lihat semua berita →
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
