<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::first()->id;

        $pages = [
            [
                'title' => 'Profil Perusahaan',
                'slug' => 'profil',
                'content' => '<h2>Tentang Poros Aktual</h2><p>Poros Aktual adalah portal berita online yang menyajikan informasi terkini, akurat, dan terpercaya. Kami berkomitmen untuk memberikan liputan berita yang berimbang dan objektif.</p><p>Didirikan pada tahun 2024, Poros Aktual hadir sebagai sumber informasi terpercaya bagi masyarakat Indonesia.</p>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'content' => '<h2>Visi</h2><p>Menjadi portal berita online terdepan dan terpercaya di Indonesia.</p><h2>Misi</h2><ul><li>Menyajikan berita yang akurat dan berimbang</li><li>Memberikan informasi yang bermanfaat bagi masyarakat</li><li>Menjaga kredibilitas dan integritas jurnalistik</li><li>Memanfaatkan teknologi untuk penyebaran informasi yang lebih baik</li></ul>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Pedoman Media Siber',
                'slug' => 'pedoman-siber',
                'content' => '<h2>Pedoman Media Siber</h2><p>Poros Aktual berpedoman pada Pedoman Media Siber yang ditetapkan oleh Dewan Pers. Berikut adalah prinsip-prinsip yang kami junjung tinggi:</p><ul><li>Akurasi dan kebenaran informasi</li><li>Independensi jurnalistik</li><li>Tanggung jawab sosial</li><li>Perlindungan narasumber</li><li>Hak jawab dan hak koreksi</li></ul>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Redaksi',
                'slug' => 'redaksi',
                'content' => '<h2>Tim Redaksi Poros Aktual</h2><p>Redaksi Poros Aktual terdiri dari jurnalis profesional yang berpengalaman di bidangnya masing-masing.</p><h3>Daftar Redaksi</h3><ul><li><strong>Editor in Chief:</strong> Editor Utama</li><li><strong>Wartawan Senior:</strong> Budi Santoso</li></ul>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<h2>Disclaimer</h2><p>Seluruh konten yang diterbitkan di Poros Aktual adalah untuk tujuan informasi. Kami tidak bertanggung jawab atas keputusan yang diambil berdasarkan informasi dari situs ini.</p><p>Informasi yang tersedia di situs ini dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.</p>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Kebijakan Privasi</h2><p>Kami menghargai privasi pengunjung situs kami. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan dan menggunakan data pengunjung.</p><h3>Pengumpulan Data</h3><p>Kami mengumpulkan data seperti alamat IP, jenis browser, dan halaman yang dikunjungi untuk keperluan analisis.</p><h3>Penggunaan Data</h3><p>Data yang dikumpulkan digunakan untuk meningkatkan kualitas layanan dan pengalaman pengunjung.</p>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
            [
                'title' => 'Hubungi Kami',
                'slug' => 'kontak',
                'content' => '<h2>Hubungi Kami</h2><p>Redaksi Poros Aktual</p><ul><li>Email: info@porosaktual.com</li><li>Telepon: +62 21 1234 5678</li><li>Alamat: Jl. Teknologi No. 1, Jakarta Selatan, Indonesia</li></ul><h2>Beriklan</h2><p>Tertarik beriklan di Poros Aktual? Hubungi tim marketing kami:</p><ul><li>Email: iklan@porosaktual.com</li><li>Telepon: +62 21 1234 5679</li></ul>',
                'author_id' => $adminId,
                'status' => 'published',
                'template' => 'default',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
