<?= $this->section('title'); ?>
<?= $this->endSection(); ?>

<?= $this->extend('layouts/public_layout'); ?>

<?= $this->section('content'); ?>
<div class="max-w-screen-xl mx-auto p-4">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Create Order</h1>
        <form action="/pesanan/create" method="post" onsubmit="addProduct()">
            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                <input type="text" name="id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="produk" class="block text-sm font-medium text-gray-700">Produk</label>
                <select name="produk" id="productSelect" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <?php foreach ($produk as $item): ?>
                        <option value="<?= $item->id ?>" data-nama="<?= $item->name ?>" data-harga="<?= $item->price ?>">
                            <?= $item->name; ?> | <?= $item->getFormattedPrice(); ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="kuantitas" class="block text-sm font-medium text-gray-700">Kuantitas</label>
                <input type="number" name="kuantitas" id="kuantitas" min="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <!-- Hidden input to store selected product -->
            <input type="hidden" name="selectedProducts" id="selectedProducts">

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold text-sm rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create</button>
                <a href="/product/list" class="text-sm text-blue-500 hover:underline">Back to Catalog</a>
            </div>
        </form>
    </div>
</div>

<script>
    function addProduct() {
        const selectElement = document.getElementById('productSelect')
        const selectedOptions = Array.from(selectElement.selectedOptions)

        const products = selectedOptions.map(option => ({
            id: option.value,
            nama: option.getAttribute('data-nama'),
            harga: option.getAttribute('data-harga'),
        }))

        // const listElement = document.createElement("li")
        // listElement.textContent = `${products.nama} | Rp${products.harga}`
        // document.getElementById("produkList").appendChild(listElement)

        // Set hidden input field with the selected values
        document.getElementById('selectedProducts').value = JSON.stringify(products);

        // document.getElementById("selectedProductsId").value = products.map(product => product.id).join(",");
    }
</script>
<?= $this->endSection(); ?>