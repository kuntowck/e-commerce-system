<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6"><?= $title; ?></h1>
    <form id="formData" action="<?= base_url('product-manager/products/' . $product->id . '/update'); ?>" method="post" class="pristine-validate" enctype="multipart/form-data" novalidate>
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
                data-pristine-type-message="Price must be a numeric value.">

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
            <label for="image_path" class="block text-sm font-medium text-gray-700">Upload Image</label>
            <?php if (isset($productImage->image_path)): ?>
                <div class="my-2">
                    <img src="<?= base_url('uploads/product-images/' . $productImage->product_id . '/thumbnail/' . $productImage->image_path); ?>" alt="<?= $productImage->image_path; ?>" width="100" class="rounded-md">
                </div>
            <?php else: ?>
                <p class="mt-1 text-sm text-gray-500">No image uploaded.</p>
            <?php endif; ?>
            <input
                type="file"
                name="image_path"
                id="image_path"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                data-pristine-required
                data-pristine-required-message="Please select a file to upload.">
            <p class="mt-1 text-sm text-gray-500" id="file_input_help">Only JPG, PNG, WebP format (MAX. 5MB).</p>

            <div id="file-type-error" class="text-xs text-red-800 text-xs font-medium mt-2" style="display: none;">
                File must be in JPG, PNG, WebP format.
            </div>

            <div id="file-size-error" class="text-xs text-red-800 mt-2" style="display: none;">
                File size must not exceed 5MB
            </div>

            <div id="preview-container" class="mt-2 mb-4 text-sm text-gray-500" src="#" alt="File Preview" style="display: none;">
                Preview:
                <iframe id="file-preview" class="w-sm h-48" frameborder="0"></iframe>
            </div>

            <div class="text-red-800 text-xs font-medium mt-2">
                <?= session('errors.image_path') ?? ''; ?>
            </div>
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
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">Update</button>
            <a href="<?= base_url('product-manager/products'); ?>" class="text-sm text-blue-500 hover:underline">Back to catalog</a>
        </div>
    </form>
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

        var fileInput = document.getElementById('image_path');
        var fileTypeError = document.getElementById('file-type-error');
        var fileSizeError = document.getElementById('file-size-error');
        var previewContainer = document.getElementById('preview-container');
        var filePreview = document.getElementById('file-preview');

        var maxSize = 5 * 1024 * 1024;
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        var allowedExtensions = ['.jpg', 'jpeg.', '.png', '.WebP'];

        pristine.addValidator(fileInput, function(value) {
            fileTypeError.style.display = 'none';
            fileSizeError.style.display = 'none';
            filePreview.style.display = 'none';

            if (fileInput.files.length === 0) {
                return true;
            }

            var file = fileInput.files[0]
            var validType = allowedTypes.includes(file.type);

            if (!validType) {
                var fileName = file.name.toLowerCase();
                validType = allowedExtensions.some(function(ext) {
                    return fileName.endsWith(ext);
                });
            }

            if (!validType) {
                fileTypeError.style.display = 'block';
                return false;
            }

            if (file.size > maxSize) {
                fileSizeError.style.display = 'block';
                return false;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                filePreview.src = e.target.result;
                filePreview.style.display = 'block';
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);


            return true;
        }, "Validation is failed.", 5, false);

        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });

        fileInput.addEventListener('change', function() {
            fileTypeError.style.display = 'none';
            fileSizeError.style.display = 'none';
            filePreview.style.display = 'none';

            pristine.validate(fileInput);
        });
    };
</script>
<?= $this->endSection() ?>