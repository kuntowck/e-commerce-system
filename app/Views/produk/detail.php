<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4 mb-10">
    <div class="bg-white shadow-sm rounded-md p-6">
        <h1 class="text-2xl font-bold mb-4">Product Detail</h1>
        <div class="mb-4">
            <h1 class="text-lg font-bold mb-2">Profile</h1>
            <p class="text-md font-semibold">
                ID:
                <span class="text-gray-500"><?= $product->id ?></span>
            </p>
            <p class="text-md font-semibold">
                Name:
                <span class="text-gray-500"><?= $product->name ?></span>
            </p>
            <p class="text-md font-semibold">
                Price:
                <span class="text-gray-500"><?= $product->getFormattedPrice() ?></span>
            </p>
            <p class="text-md font-semibold">
                Stock:
                <span class="text-gray-500"><?= $product->stock ?></span>
            </p>
            <p class="text-md font-semibold">
                Status:
                <span class="text-gray-500"><?= $product->status ?></span>
            </p>
        </div>
        <div class="flex items-center justify-between">
            <a href="/produk" class="text-sm text-blue-500 hover:underline">Back to Product List</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>