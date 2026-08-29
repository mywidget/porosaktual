<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;
use Illuminate\Support\Str;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'slot_id' => 1,
                'title' => 'Header Banner - Poros Aktual',
                'type' => 'html_script',
                'html_code' => '<div style="background:linear-gradient(135deg,#1e40af,#7c3aed);color:#fff;text-align:center;padding:20px;border-radius:8px;font-family:sans-serif;"><strong style="font-size:18px;">📰 Poros Aktual</strong><br><span style="font-size:13px;opacity:0.9;">Portal Berita Terpercaya Indonesia</span></div>',
                'url' => '/',
                'start_date' => now()->subDays(7),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'slot_id' => 2,
                'title' => 'Leaderboard - Promo Spesial',
                'type' => 'html_script',
                'html_code' => '<div style="background:linear-gradient(135deg,#dc2626,#ea580c);color:#fff;text-align:center;padding:18px;border-radius:8px;font-family:sans-serif;"><strong style="font-size:16px;">🔥 PROMO SPESIAL HARI INI</strong><br><span style="font-size:13px;">Diskon hingga 70% - Belanja Sekarang!</span></div>',
                'url' => '#',
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(14),
                'is_active' => true,
            ],
            [
                'slot_id' => 3,
                'title' => 'Sidebar Top - Berlangganan',
                'type' => 'html_script',
                'html_code' => '<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:16px;text-align:center;font-family:sans-serif;"><strong style="color:#166534;font-size:14px;">📧 Newsletter Gratis</strong><br><span style="font-size:12px;color:#4b5563;">Dapatkan berita terkini langsung di inbox</span><br><button style="margin-top:8px;background:#16a34a;color:#fff;border:none;padding:6px 16px;border-radius:4px;font-size:12px;cursor:pointer;">Berlangganan</button></div>',
                'url' => '#',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'slot_id' => 4,
                'title' => 'Sidebar Sticky - Download App',
                'type' => 'html_script',
                'html_code' => '<div style="background:linear-gradient(135deg,#0ea5e9,#2563eb);color:#fff;text-align:center;padding:20px;border-radius:8px;font-family:sans-serif;"><strong style="font-size:15px;">📱 Download Aplikasi</strong><br><span style="font-size:12px;opacity:0.9;">Baca berita kapan saja, di mana saja</span><br><button style="margin-top:10px;background:#fff;color:#2563eb;border:none;padding:8px 20px;border-radius:20px;font-size:12px;font-weight:bold;cursor:pointer;">Download Sekarang</button></div>',
                'url' => '#',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(90),
                'is_active' => true,
            ],
            [
                'slot_id' => 5,
                'title' => 'In Article Top - Baca Juga',
                'type' => 'html_script',
                'html_code' => '<div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;font-family:sans-serif;"><span style="font-size:12px;color:#92400e;">📖 <strong>Baca Juga:</strong></span><br><a href="#" style="font-size:13px;color:#1e40af;text-decoration:none;">5 Berita Penting Hari Ini yang Wajib Anda Ketahui</a></div>',
                'url' => '#',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'slot_id' => 6,
                'title' => 'In Article Middle - Polling',
                'type' => 'html_script',
                'html_code' => '<div style="background:#ede9fe;border:1px solid #c4b5fd;border-radius:8px;padding:14px 16px;text-align:center;font-family:sans-serif;"><strong style="font-size:13px;color:#5b21b6;">📊 Polling Pembaca</strong><br><span style="font-size:12px;color:#6b7280;">Menurut Anda, apa solusi terbaik untuk masalah ini?</span><br><div style="margin-top:8px;display:flex;gap:6px;justify-content:center;"><button style="background:#7c3aed;color:#fff;border:none;padding:4px 12px;border-radius:4px;font-size:11px;cursor:pointer;">Opsi A</button><button style="background:#7c3aed;color:#fff;border:none;padding:4px 12px;border-radius:4px;font-size:11px;cursor:pointer;">Opsi B</button></div></div>',
                'url' => '#',
                'start_date' => now(),
                'end_date' => now()->addDays(15),
                'is_active' => true,
            ],
            [
                'slot_id' => 7,
                'title' => 'In Article Bottom - Artikel Terkait',
                'type' => 'html_script',
                'html_code' => '<div style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:14px 16px;font-family:sans-serif;"><strong style="font-size:13px;color:#334155;">🔗 Artikel Populer Minggu Ini</strong><ul style="margin:8px 0 0;padding-left:16px;font-size:12px;color:#475569;"><li style="margin-bottom:4px;"><a href="#" style="color:#1e40af;text-decoration:none;">Topik Ekonomi Terkini</a></li><li style="margin-bottom:4px;"><a href="#" style="color:#1e40af;text-decoration:none;">Update Politik Nasional</a></li><li><a href="#" style="color:#1e40af;text-decoration:none;">Teknologi Terbaru 2026</a></li></ul></div>',
                'url' => '#',
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(20),
                'is_active' => true,
            ],
            [
                'slot_id' => 8,
                'title' => 'Before Footer - Kontak Redaksi',
                'type' => 'html_script',
                'html_code' => '<div style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;text-align:center;padding:20px;border-radius:8px;font-family:sans-serif;"><strong style="font-size:14px;">📬 Hubungi Redaksi</strong><br><span style="font-size:12px;opacity:0.8;">Tips & informasi: redaksi@porosaktual.com</span><br><span style="font-size:12px;opacity:0.8;">Iklan & Kerjasama: iklan@porosaktual.com</span></div>',
                'url' => 'mailto:redaksi@porosaktual.com',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(90),
                'is_active' => true,
            ],
            [
                'slot_id' => 9,
                'title' => 'Mobile Banner - Install App',
                'type' => 'html_script',
                'html_code' => '<div style="background:#1e40af;color:#fff;text-align:center;padding:8px 12px;border-radius:4px;font-family:sans-serif;font-size:12px;"><strong>📱 Install Aplikasi Poros Aktual</strong> - Baca Lebih Cepat!</div>',
                'url' => '#',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'slot_id' => 10,
                'title' => 'Floating Sticky - Promo Membership',
                'type' => 'html_script',
                'html_code' => '<div style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;text-align:center;padding:14px;border-radius:8px;font-family:sans-serif;"><strong style="font-size:13px;">⭐ Upgrade ke Premium</strong><br><span style="font-size:11px;">Bebas iklan + konten eksklusif</span><br><button style="margin-top:6px;background:#fff;color:#d97706;border:none;padding:4px 14px;border-radius:12px;font-size:11px;font-weight:bold;cursor:pointer;">Coba Gratis</button></div>',
                'url' => '#',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ],
        ];

        foreach ($ads as $ad) {
            Advertisement::create($ad);
        }
    }
}
