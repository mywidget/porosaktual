<?php $__env->startSection('title', 'Edit Breaking News'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Breaking News</h1>
        <a href="<?php echo e(route('admin.breaking-news.index')); ?>" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">Batal</a>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <ul class="text-sm text-red-700 dark:text-red-400 list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.breaking-news.update', $breakingNews->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="<?php echo e(old('title', $breakingNews->title)); ?>" required
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL</label>
                <input type="text" name="url" value="<?php echo e(old('url', $breakingNews->url)); ?>" id="urlField"
                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div x-data="{
                posts: <?php echo \Illuminate\Support\Js::from(\App\Models\Post::latest()->limit(100)->get()->map(fn($p) => ['id' => $p->id, 'title' => $p->title, 'url' => route('post.show', $p->slug)]))->toHtml() ?>,
                selectedPost: '<?php echo e(old('post_id', $breakingNews->post_id)); ?>',
                selectPost(id) {
                    this.selectedPost = id;
                    if (id) {
                        const post = this.posts.find(p => p.id == id);
                        if (post) {
                            document.getElementById('urlField').value = post.url;
                        }
                    }
                }
            }">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Berita Terkait</label>
                <select name="post_id" @change="selectPost($event.target.value)" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tidak ada</option>
                    <template x-for="post in posts" :key="post.id">
                        <option :value="post.id" x-text="post.title" :selected="selectedPost == post.id"></option>
                    </template>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date', $breakingNews->start_date?->format('Y-m-d\TH:i'))); ?>" required
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date', $breakingNews->end_date?->format('Y-m-d\TH:i'))); ?>" required
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioritas</label>
                    <input type="number" name="priority" value="<?php echo e(old('priority', $breakingNews->priority)); ?>" min="0"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="is_active" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" <?php echo e(old('is_active', $breakingNews->is_active) ? 'selected' : ''); ?>>Aktif</option>
                        <option value="0" <?php echo e(old('is_active', !$breakingNews->is_active) ? 'selected' : ''); ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\porosaktual\resources\views/admin/breaking-news/edit.blade.php ENDPATH**/ ?>