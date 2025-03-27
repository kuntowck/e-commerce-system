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

    <form action="<?= site_url('product-manager/products/report'); ?>" method="get" class="mb-6">
        <div class="grid grid-cols-4 gap-4 mt-4 justify-center items-center">
            <div>
                <select name="category_id" class="form-select mt-1 block w-full px-3 py-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="this.form.submit()">
                    <option value="">All Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id; ?>" <?= ($filter['category_id'] ?? '' == $category->id) ? 'selected' : ''; ?>>
                            <?= ucfirst($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <a href="<?= base_url('product-manager/products/report'); ?>" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Reset</a>
            </div>
        </div>
    </form>

    <div class="mb-4">
        <form action="<?= site_url('product-manager/products/report-excel'); ?>" method="get">
            <input type="hidden" name="category_id" value="<?= $filter['category_id'] ?? ''; ?>">

            <button type="submit" class="px-4 py-2 bg-green-100 text-green-700 border border-green-200 font-semibold text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:bg-green-700 focus:ring-green-500 focus:ring-offset-2 text-center cursor-pointer">Export Excel</button>
        </form>
    </div>

    <div class="overflow-x-auto mt-6">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Added</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $count = 1;
                foreach ($products as $product): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $count++ ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $product->name ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $product->category_name; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $product->getFormattedPrice() ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $product->stock ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= $product->created_at->humanize() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>