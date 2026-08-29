@props([
    'title' => config('app.name'),
    'description' => '',
    'image' => '',
    'url' => '',
    'type' => 'website',
    'keywords' => '',
])

@php
    $appName = config('app.name');
    $fullTitle = $title === $appName ? $title : $title . ' - ' . $appName;
    $description = $description ?: config('app.description', 'Portal berita terkini Indonesia');
    $currentUrl = $url ?: url()->current();
    $imageUrl = $image ? (Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image)) : asset('images/default-og.jpg');
    $keywords = $keywords ?: config('app.keywords', 'berita, news, Indonesia, terkini');
@endphp

<title>{{ $fullTitle }}</title>

<meta name="description" content="{{ Str::limit(strip_tags($description), 160) }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ config('app.name') }}">
<link rel="canonical" href="{{ $currentUrl }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($description), 200) }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:site_name" content="{{ $appName }}">
<meta property="og:locale" content="id_ID">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($description), 200) }}">
<meta name="twitter:image" content="{{ $imageUrl }}">
@if(config('app.twitter_handle'))
<meta name="twitter:site" content="{{ config('app.twitter_handle') }}">
@endif