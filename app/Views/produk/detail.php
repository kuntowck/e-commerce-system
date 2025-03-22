<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="grid grid-cols-2 gap-12">
        <div class="grid grid-cols-2 gap-4 justify-center">
            <div class="flex flex-col gap-4 items-end">
                <?php foreach ($images as $image): ?>
                    <div>
                        <img class="rounded-lg" src="<?= base_url('uploads/product-images/' . $product->id . '/thumbnail/' . $image->image_path) ?>" alt="<?= $image->image_path; ?>" />
                    </div>
                <?php endforeach; ?>
            </div>

            <div>
                <img class="rounded-lg w-full h-full" src="<?= base_url('uploads/product-images/' . $product->id . '/medium/' . $product->image_path) ?>" alt="<?= $product->image_path; ?>" />
            </div>
        </div>

        <div class="">
            <div class="mt-4 flex gap-0">
                <?= $product->is_new ? view_cell('BadgeCell', ['text' => 'New']) : ''; ?>
                <?= $product->is_sale ? view_cell('BadgeCell', ['text' => 'Sale']) : ''; ?>
            </div>

            <div class="py-2 mb-4">
                <h3 class="text-2xl font-bold tracking-tight text-gray-900 "><?= $product->getFormattedPrice(); ?></h3>
                <h5 class="text-lg font-semibold tracking-tight text-gray-900 "><?= $product->name; ?></h5>
                <p class="font-regular text-gray-500"><?= $product->category_name; ?></p>
                <p class="font-medium text-gray-700"><?= $product->description; ?></p>
                <p class="font-medium text-gray-700"><?= $product->stock; ?> Stocks (<?= $product->status; ?>)</p>
            </div>
            <div class="mb-4">
                <a href="<?= base_url('product-manager/products'); ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Back to Product List
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-3.5 h-3.5 ms-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>