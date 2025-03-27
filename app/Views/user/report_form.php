<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?php if (in_groups('admin')): ?>
    <?= $this->extend('layouts/admin_layout'); ?>
<?php else: ?>
    <?= $this->extend('layouts/public_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-4"><?= $title; ?></h1>

    <form action="<?= site_url('admin/users/report-pdf'); ?>" method="post" target="_blank" class="mb-6">
        <div class="flex gap-4 mt-4 items-center">
            <div class="flex-1">
                <select name="role" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Roles</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role->id; ?>">
                            <?= ucfirst($role->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <a href="<?= base_url('admin/users/report'); ?>" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Reset</a>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-100 text-blue-700 border border-blue-200 font-semibold text-sm rounded-md hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:bg-blue-700 focus:ring-blue-500 focus:ring-offset-2 text-center cursor-pointer">Generate PDF</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>