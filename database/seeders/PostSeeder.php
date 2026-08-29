<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::whereNull('parent_id')->get();
        $tags = Tag::all();
        $authorIds = User::pluck('id')->toArray();

        $samplePosts = [
            ['title' => 'Prabowo Resmi Dilantik sebagai Presiden ke-8 RI', 'category' => 'politik', 'content' => 'Prabowo Subianto secara resmi dilantik sebagai Presiden Republik Indonesia ke-8 menggantikan Joko Widodo dalam upacara pelantikan di Gedung Nusantara, Senayan, Jakarta.', 'is_trending' => true, 'is_breaking' => true],
            ['title' => 'Indonesia Raih Pertumbuhan Ekonomi 5,2 Persen', 'category' => 'ekonomi', 'content' => 'Pertumbuhan ekonomi Indonesia pada kuartal pertama 2026 mencapai 5,2 persen, melebihi ekspektasi analis. Kontribusi utama datang dari sektor konsumsi domestik dan ekspor.', 'is_trending' => true],
            ['title' => 'Apple Rilis iPhone 17 dengan Fitur AI Canggih', 'category' => 'teknologi', 'content' => 'Apple secara resmi merilis iPhone 17 dengan fitur kecerdasan buatan yang lebih canggih. Fitur baru termasuk penerjemah real-time dan kamera dengan AI computational photography.', 'is_highlight' => true],
            ['title' => 'Timnas Indonesia Lolos ke Piala Dunia 2026', 'category' => 'olahraga', 'content' => 'Timnas Indonesia berhasil lolos ke Piala Dunia 2026 setelah mengalahkan lawan-lawannya di babak kualifikasi. Seluruh rakyat Indonesia berbahagia atas pencapaian bersejarah ini.', 'is_trending' => true, 'is_highlight' => true],
            ['title' => 'Banjir Besar Melanda Jakarta Selatan', 'category' => 'nasional', 'content' => 'Hujan deras yang mengguyur Jakarta selama 24 jam mengakibatkan banjir besar di beberapa wilayah Jakarta Selatan. Ribuan warga harus mengungsi.', 'is_breaking' => true],
            ['title' => 'The Fed Tahan Suku Bunga Acuan', 'category' => 'ekonomi', 'content' => 'Federal Reserve memutuskan untuk menahan suku bunga acuan di level saat ini. Keputusan ini mempengaruhi pergerakan pasar global termasuk Rupiah.'],
            ['title' => 'Samsung Galaxy S26 dengan Kamera 200MP', 'category' => 'teknologi', 'content' => 'Samsung Galaxy S26 hadir dengan kamera utama 200MP dan fitur night mode yang lebih baik. Harga mulai dari Rp 15 juta.'],
            ['title' => 'Harga Emas Antam Tembus Rp 1,2 Juta per Gram', 'category' => 'ekonomi', 'content' => 'Harga emas Antam pecahan 1 gram menembus Rp 1,2 juta per gram. Peningkatan harga didorong oleh ketidakpastian ekonomi global.'],
            ['title' => 'Gempa 6.1 SR Guncang Sulawesi', 'category' => 'nasional', 'content' => 'Gempa bumi berkekuatan 6.1 Skala Richter mengguncang wilayah Sulawesi Tengah. BMKG mengimbau warga untuk tetap waspada.', 'is_breaking' => true],
            ['title' => 'Liga 1: Persija vs Persib Berakhir Imbang', 'category' => 'olahraga', 'content' => 'Pertandingan seru antara Persija Jakarta dan Persib Bandung berakhir imbang 2-2. Pertandingan berlangsung sengit di Stadion Utama Gelora Bung Karno.'],
            ['title' => 'Elon Musk Luncurkan Starship Generasi Baru', 'category' => 'teknologi', 'content' => 'SpaceX berhasil meluncurkan Starship generasi terbaru ke orbit. Ini adalah langkah besar menuju misi ke Mars.'],
            ['title' => 'BI Prediksi Inflasi Tetap Terkendali', 'category' => 'ekonomi', 'content' => 'Bank Indonesia memprediksi inflasi akan tetap terkendali di kisaran 2-4 persen sepanjang tahun 2026.'],
            ['title' => 'Nadiem Makarim Ucapkan Selamat kepada Prabowo', 'category' => 'politik', 'content' => 'Menteri Pendidikan Nadiem Makarim mengucapkan selamat kepada Prabowo Subianto atas pelantikannya sebagai presiden.'],
            ['title' => 'Tips Diet Sehat untuk Pemula', 'category' => 'lifestyle', 'content' => 'Diet sehat tidak harus menyiksa. Berikut tips diet sehat untuk pemula yang bisa Anda coba di rumah.'],
            ['title' => 'Tren Fashion 2026: Warna Earth Tone Mendominasi', 'category' => 'lifestyle', 'content' => 'Warna-warna earth tone diprediksi akan mendominasi tren fashion tahun 2026. Desainer lokal mulai mengadopsi warna ini.'],
            ['title' => 'Film Indonesia Terbaru Raih 10 Juta Penonton', 'category' => 'hiburan', 'content' => 'Film Indonesia terbaru berhasil meraih 10 juta penonton dalam waktu 2 minggu. Film ini menjadi film terlaris tahun ini.'],
            ['title' => 'Wildan Kurniawan Raih Beasiswa ke MIT', 'category' => 'pendidikan', 'content' => 'Wildan Kurniawan, siswa SMA dari Surabaya, berhasil meraih beasiswa penuh ke Massachusetts Institute of Technology (MIT).'],
            ['title' => 'Doa dan Dzikir untuk Ketenangan Hati', 'category' => 'islami', 'content' => 'Berikut kumpulan doa dan dzikir yang bisa diamalkan untuk mendapatkan ketenangan hati dan jiwa.'],
            ['title' => 'Pajak Elektronik Diberlakukan Mulai Januari 2026', 'category' => 'nasional', 'content' => 'Pemerintah resmi memberlakukan sistem pajak elektronik mulai Januari 2026. Wajib pajak harus menggunakan sistem baru ini.'],
            ['title' => 'Tiket MotoGP Mandalika 2026 Sold Out', 'category' => 'olahraga', 'content' => 'Tiket MotoGP Mandalika 2026 habis terjual dalam waktu 3 hari setelah pembukaan penjualan. Antusiasme penonton sangat tinggi.'],
        ];

        foreach ($samplePosts as $index => $postData) {
            $category = $categories->where('slug', $postData['category'])->first();

            $post = Post::create([
                'title' => $postData['title'],
                'slug' => \Illuminate\Support\Str::slug($postData['title']),
                'excerpt' => substr($postData['content'], 0, 150) . '...',
                'content' => '<p>' . $postData['content'] . '</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                'author_id' => $authorIds[array_rand($authorIds)],
                'category_id' => $category->id,
                'status' => 'published',
                'published_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'is_trending' => $postData['is_trending'] ?? false,
                'is_breaking' => $postData['is_breaking'] ?? false,
                'is_highlight' => $postData['is_highlight'] ?? false,
                'is_sponsored' => false,
                'views_count' => rand(100, 10000),
                'reading_time' => rand(3, 10),
            ]);

            // Attach random tags
            $post->tags()->attach($tags->random(min(3, $tags->count()))->pluck('id')->toArray());
        }
    }
}
