<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Update Product</h1>
        <form id="formData" action="/produk/<?= $product->id; ?>/update" method="post" novalidate>
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="<?= $product->name; ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    data-pristine-required
                    data-pristine-required-message="Product name is required."
                    data-pristine-minlength="3"
                    data-pristine-minlength-message="Product name must be at leat 3 characters long.">

                <div class="text-red-800 text-xs font-medium mt-2">
                    <?= session('errors.name') ?? ''; ?>
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input
                    id="description"
                    name="description"
                    value="<?= $product->description; ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input
                    id="price"
                    type="text"
                    name="price"
                    value="<?= $product->getFormattedPrice(); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    data-pristine-required
                    data-pristine-required-message="Price is required."
                    data-pristine-type="numeric"
                    data-pristine-type-message="Price must be a numeric value."
                    data-pristine-min="1"
                    data-pristine-min-message="price must be greater than 0.">

                <div class="text-red-800 text-xs font-medium mt-2">
                    <?= session('errors.price') ?? ''; ?>
                </div>
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input
                    id="stock"
                    type="number"
                    name="stock"
                    value="<?= $product->stock; ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    data-pristine-required
                    data-pristine-required-message="Stock is required."
                    data-pristine-type="integer"
                    data-pristine-type-message="Stock must be a number.">

                <div class="text-red-800 text-xs font-medium mt-2">
                    <?= session('errors.stock') ?? ''; ?>
                </div>
            </div>


            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id; ?>"
                            <?= $category->id === $product->category_id ? 'selected' : '' ?>>
                            <?= $category->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="available" <?= $product->status === 'available' ? 'selected' : '' ?>>
                        Available
                    </option>
                    <option value="unavailable" <?= $product->status === 'unavailable' ? 'selected' : '' ?>>
                        Unavailable
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="is_new" class="block text-sm font-medium text-gray-700"> New</label>
                <select name="is_new" id="is_new" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="1" <?= $product->is_new === '1' ? 'selected' : ''; ?>>
                        Yes
                    </option>
                    <option value="0" <?= $product->is_new === '0' ? 'selected' : ''; ?>>
                        No
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="is_sale" class="block text-sm font-medium text-gray-700">Sale</label>
                <select name="is_sale" id="is_sale" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="1" <?= $product->is_sale === '1' ? 'selected' : ''; ?>>
                        Yes
                    </option>
                    <option value="0" <?= $product->is_sale === '0' ? 'selected' : ''; ?>>
                        No
                    </option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">Update</button>
                <a href="/produk" class="text-sm text-blue-500 hover:underline">Back to catalog</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let pristine;
    window.onload = function() {
        let form = document.getElementById("formData");

        var pristine = new Pristine(form, {
            classTo: 'mb-4',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-4',
            errorTextTag: 'div',
            errorTextClass: 'text-red-800 text-xs font-medium mt-2'
        });

        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

    };
</script>
<?= $this->endSection() ?>