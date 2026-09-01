<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Customizable Route Prefixes
    |--------------------------------------------------------------------------
    |
    | Konfigurasi prefix URL untuk setiap jenis konten.
    | Setiap prefix bisa dikosongkan untuk URL tanpa prefix (seperti WordPress).
    | Contoh: prefix kosong untuk post → example.com/judul-berita
    |
    */

    'prefixes' => [

        'post' => env('ROUTE_PREFIX_POST', 'news'),

        'category' => env('ROUTE_PREFIX_CATEGORY', 'kategori'),

        'tag' => env('ROUTE_PREFIX_TAG', 'tag'),

        'author' => env('ROUTE_PREFIX_AUTHOR', 'penulis'),

        'page' => env('ROUTE_PREFIX_PAGE', 'page'),

        'search' => env('ROUTE_PREFIX_SEARCH', 'pencarian'),

        'video' => env('ROUTE_PREFIX_VIDEO', 'video'),

    ],

];
