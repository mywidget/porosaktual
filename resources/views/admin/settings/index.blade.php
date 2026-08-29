@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'website' }">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pengaturan</h1>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="border-b border-gray-100 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button @click="activeTab = 'website'" :class="activeTab === 'website' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">Website</button>
                <button @click="activeTab = 'social'" :class="activeTab === 'social' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">Social Media</button>
                <button @click="activeTab = 'analytics'" :class="activeTab === 'analytics' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">Analytics</button>
                <button @click="activeTab = 'adsense'" :class="activeTab === 'adsense' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">Google AdSense</button>
                <button @click="activeTab = 'comments'" :class="activeTab === 'comments' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">Komentar</button>
                <button @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">SEO</button>
            </nav>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="p-6">
                <div x-show="activeTab === 'website'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Website</h2>
                    <div class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Website <span class="text-red-500">*</span></label>
                            <input type="text" name="settings[site_name]" value="{{ $settings['site_name'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                            <textarea name="settings[site_description]" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                            <input type="file" name="site_logo" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            @if(isset($settings['site_logo']) && $settings['site_logo'])
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="mt-2 h-10" alt="Logo">
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Favicon</label>
                            <input type="file" name="site_favicon" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" class="mt-2 h-10" alt="Favicon">
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo Footer (Warna Satu / Monokrom)</label>
                            <input type="file" name="site_footer_logo" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            @if(isset($settings['site_footer_logo']) && $settings['site_footer_logo'])
                                <img src="{{ asset('storage/' . $settings['site_footer_logo']) }}" class="mt-2 h-10" alt="Footer Logo">
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Logo untuk footer dengan background gelap (disarankan warna putih/monokrom)</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Footer Text</label>
                            <input type="text" name="settings[site_footer]" value="{{ $settings['site_footer'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'social'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Social Media</h2>
                    <div class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Facebook URL</label>
                            <input type="url" name="settings[social_facebook]" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://facebook.com/...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Twitter / X URL</label>
                            <input type="url" name="settings[social_twitter]" value="{{ $settings['social_twitter'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://twitter.com/...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram URL</label>
                            <input type="url" name="settings[social_instagram]" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://instagram.com/...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">YouTube URL</label>
                            <input type="url" name="settings[social_youtube]" value="{{ $settings['social_youtube'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://youtube.com/...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TikTok URL</label>
                            <input type="url" name="settings[social_tiktok]" value="{{ $settings['social_tiktok'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://tiktok.com/...">
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'analytics'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Analytics</h2>
                    <div class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Analytics ID</label>
                            <input type="text" name="settings[google_analytics_id]" value="{{ $settings['google_analytics_id'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="G-XXXXXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Tag Manager ID</label>
                            <input type="text" name="settings[google_tag_manager_id]" value="{{ $settings['google_tag_manager_id'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="GTM-XXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Facebook Pixel ID</label>
                            <input type="text" name="settings[facebook_pixel_id]" value="{{ $settings['facebook_pixel_id'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="1234567890">
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'adsense'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Google AdSense</h2>
                    <div class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Publisher ID</label>
                            <input type="text" name="settings[adsense_publisher_id]" value="{{ $settings['adsense_publisher_id'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="pub-XXXXXXXXXXXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Header Ad Slot</label>
                            <input type="text" name="settings[adsense_header_slot]" value="{{ $settings['adsense_header_slot'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="1234567890">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sidebar Ad Slot</label>
                            <input type="text" name="settings[adsense_sidebar_slot]" value="{{ $settings['adsense_sidebar_slot'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="1234567890">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">In-Article Ad Slot</label>
                            <input type="text" name="settings[adsense_inarticle_slot]" value="{{ $settings['adsense_inarticle_slot'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="1234567890">
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'comments'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Komentar</h2>
                    <div class="space-y-4 max-w-2xl">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Aktifkan Komentar</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Izinkan pengunjung mengirim komentar pada artikel</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="settings[comment_enabled]" value="1" {{ ($settings['comment_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Moderasi Komentar</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Komentar harus disetujui admin sebelum tampil di halaman</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="settings[comment_moderation]" value="1" {{ ($settings['comment_moderation'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'seo'" x-transition>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan SEO Default (Homepage)</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Pengaturan SEO default untuk halaman utama. Halaman berita menggunakan SEO dari masing-masing post.</p>
                    <div class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                            <input type="text" name="settings[seo_meta_title]" value="{{ $settings['seo_meta_title'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Poros Aktual - Portal Berita Terpercaya">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Judul yang muncul di tab browser dan hasil pencarian Google</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                            <textarea name="settings[seo_meta_description]" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Portal berita terkini Indonesia...">{{ $settings['seo_meta_description'] ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Deskripsi yang muncul di hasil pencarian Google (maksimal 160 karakter)</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Keywords</label>
                            <input type="text" name="settings[seo_meta_keywords]" value="{{ $settings['seo_meta_keywords'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="berita, news, Indonesia, terkini">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pisahkan dengan koma</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">OG Image (Social Share Image)</label>
                            <input type="file" name="seo_og_image" accept="image/*" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            @if(!empty($settings['seo_og_image']))
                                <img src="{{ asset('storage/' . $settings['seo_og_image']) }}" class="mt-2 h-20 rounded" alt="OG Image">
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Gambar yang muncul saat link dibagikan ke social media (disarankan 1200x630px)</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google News Verification</label>
                            <input type="text" name="settings[google_news_verification]" value="{{ $settings['google_news_verification'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="XXXXXXXXXXXXXXXXXXXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Search Console Verification</label>
                            <input type="text" name="settings[google_search_console]" value="{{ $settings['google_search_console'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="XXXXXXXXXXXXXXXXXXXXXXXX">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
