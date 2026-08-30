<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <!-- Quill Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - <?php echo e(config('app.name', 'Poros Aktual')); ?> CMS</title>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="h-full bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">

    
    <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>

    
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 dark:bg-gray-950 text-white flex flex-col transition-transform duration-200 lg:translate-x-0">

        
        <div class="flex items-center justify-center h-16 flex-shrink-0 border-b border-gray-700">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-xl font-extrabold">
                <span class="text-blue-400">Poros</span><span class="text-red-400">Aktual</span>
                <span class="text-xs font-normal text-gray-400 block -mt-1">CMS</span>
            </a>
        </div>

        
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <?php
                $adminNav = [
                    ['route' => 'admin.dashboard', 'label' => 'Dasbor', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>', 'permission' => 'manage-dashboard'],
                    ['route' => 'admin.posts.index', 'label' => 'Artikel', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>', 'permission' => 'manage-posts'],
                    ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>', 'permission' => 'manage-categories'],
                    ['route' => 'admin.tags.index', 'label' => 'Tag', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>', 'permission' => 'manage-tags'],
                    ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>', 'permission' => 'manage-users'],
                    ['route' => 'admin.pages.index', 'label' => 'Halaman', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>', 'permission' => 'manage-pages'],
                    ['route' => 'admin.advertisements.index', 'label' => 'Iklan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>', 'permission' => 'manage-advertisements'],
                    ['route' => 'admin.comments.index', 'label' => 'Komentar', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>', 'permission' => 'manage-comments'],
                    ['route' => 'admin.menus.index', 'label' => 'Menu', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>', 'permission' => 'manage-menus'],
                    ['route' => 'admin.media.index', 'label' => 'Media', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'permission' => 'manage-media'],
                    ['route' => 'admin.settings.index', 'label' => 'Pengaturan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>', 'permission' => 'manage-settings'],
                    ['route' => 'admin.breaking-news.index', 'label' => 'Berita Terkini', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>', 'permission' => 'manage-breaking-news'],
                ];
            ?>

            <?php $__currentLoopData = $adminNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(auth()->check() && auth()->user()->hasPermissionTo($item['permission'])): ?>
                    <?php
                        $isActive = request()->routeIs(basename($item['route']) . '*') || request()->routeIs($item['route']);
                    ?>
                    <a href="<?php echo e(route($item['route'])); ?>"
                       class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition
                              <?php echo e($isActive ? 'bg-blue-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'); ?>">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $item['icon']; ?></svg>
                        <?php echo e($item['label']); ?>

                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        
        <div class="p-3 border-t border-gray-700">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Lihat Website
            </a>
        </div>
    </aside>

    
    <div class="lg:ml-64 min-h-screen flex flex-col">

        
        <header class="bg-white dark:bg-gray-800 shadow-sm h-16 flex items-center justify-between px-6 flex-shrink-0 sticky top-0 z-30">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <span class="text-sm text-gray-500 dark:text-gray-400 hidden sm:block ml-4">
                <?php echo e(now()->translatedFormat('l, d F Y')); ?>

            </span>

            <div class="ml-auto relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 px-3 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <img src="<?php echo e(auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name)); ?>"
                         alt="" class="w-8 h-8 rounded-full">
                    <span class="text-sm font-medium hidden sm:block"><?php echo e(auth()->user()->name); ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak x-transition
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-50">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">Profil</a>
                    <hr class="my-1 border-gray-200 dark:border-gray-600">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 text-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        
        <main class="flex-1 p-6">
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-300 rounded-lg text-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-300 rounded-lg text-sm">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Quill Editor Script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(session('success')): ?>
    <script>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?php echo e(session('success')); ?>', timer: 2000, showConfirmButton: false });
    </script>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <script>
        Swal.fire({ icon: 'error', title: 'Gagal', text: '<?php echo e(session('error')); ?>' });
    </script>
    <?php endif; ?>
    <script>
        document.querySelectorAll('form[onsubmit]').forEach(form => {
            const msg = form.getAttribute('onsubmit');
            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const text = msg.match(/return confirm\('(.+?)'\)/)?.[1] || 'Yakin ingin menghapus?';
                Swal.fire({
                    title: 'Konfirmasi',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH E:\laragon\www\porosaktual\resources\views/layouts/admin.blade.php ENDPATH**/ ?>