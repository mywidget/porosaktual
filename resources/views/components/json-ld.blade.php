@props(['data'])

@if($data)
    @php
        $jsonLd = is_array($data) ? $data : json_decode($data, true);
    @endphp

    @if($jsonLd)
        <script type="application/ld+json">
            {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
@endif