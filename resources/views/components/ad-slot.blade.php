@props(['location' => 'header', 'limit' => 3])

@php
    $advertisements = \App\Models\Advertisement::whereHas('slot', function ($q) use ($location) {
        $q->where('location', $location)->where('is_active', true);
    })
        ->where('is_active', true)
        ->where(function ($q) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', now());
        })
        ->where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', now());
        })
        ->with('slot')
        ->limit($limit)
        ->get();
@endphp

@if($advertisements->count())
    <div class="{{ $attributes->get('class', '') }}">
        @foreach($advertisements as $advertisement)
            <div class="ad-container relative my-4">
                <div class="text-center text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
                    Advertisement
                </div>
                <div class="rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-center">
                    @if($advertisement->type === 'banner' && $advertisement->banner_image)
                        <a href="{{ $advertisement->url ?? '#' }}" target="_blank" rel="noopener noreferrer nofollow" class="block">
                            <img
                                src="{{ asset('storage/' . $advertisement->banner_image) }}"
                                alt="{{ $advertisement->title }}"
                                class="w-full h-auto object-cover"
                                loading="lazy"
                            >
                        </a>
                    @elseif($advertisement->type === 'html_script' && $advertisement->html_code)
                        <div class="ad-html p-2 md:p-4">
                            {!! $advertisement->html_code !!}
                        </div>
                    @elseif($advertisement->type === 'adsense' && $advertisement->html_code)
                        <div class="ad-adsense p-2 md:p-4">
                            {!! $advertisement->html_code !!}
                        </div>
                    @elseif($advertisement->type === 'internal' && $advertisement->url)
                        <a href="{{ $advertisement->url }}" class="block p-4 text-sm font-medium text-blue-700 dark:text-blue-400 hover:underline">
                            {{ $advertisement->title }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
