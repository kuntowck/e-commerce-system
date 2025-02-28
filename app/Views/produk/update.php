<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Update Product</h1>
        <form action="/produk/<?= $product->id; ?>/update" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" value="<?= $product->name; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <?php if (! empty($errors['name'])): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <p><?= esc($errors['name']) ?></p>
                    </div>
                <?php endif ?>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input id="price" type="text" name="price" value="<?= $product->getFormattedPrice(); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <?php if (! empty($errors['price'])): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <p><?= esc($errors['price']) ?></p>
                    </div>
                <?php endif ?>
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input id="stock" type="text" name="stock" value="<?= $product->stock; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <?php if (! empty($errors['stock'])): ?>
                    <div class="text-red-800 text-xs font-medium mt-2">
                        <p><?= esc($errors['stock']) ?></p>
                    </div>
                <?php endif ?>
            </div>


            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id; ?>"
                            <?= $category->id == $product->category_id ? 'selected' : '' ?>>
                            <?= $category->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="available" <?= $product->status == 'available' ? 'selected' : '' ?>>
                        Available
                    </option>
                    <option value="unavailable" <?= $product->status == 'unavailable' ? 'selected' : '' ?>>
                        Unavailable
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update</button>
                <a href="/produk" class="text-sm text-blue-500 hover:underline">Back to catalog</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>