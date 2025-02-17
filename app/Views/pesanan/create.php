<!DOCTYPE html>
<html>

<head>
    <title>Create Order</title>
</head>

<body>
    <h1>Create Order</h1>
    <form action="/pesanan/create" method="post" onsubmit="addProduct()">
        <label for="id">Id:</label>
        <input type="text" name="id" required><br>

        <label for="produk">Produk:</label>
        <select name="produk" id="productSelect">
            <?php foreach ($produk as $item): ?>
                <option value="<?= $item->getId() ?>" data-nama="<?= $item->getNama() ?>" data-harga="<?= $item->getHarga() ?>">
                    <?= $item->getNama(); ?> | Rp<?= $item->getHarga(); ?>
                </option>
            <?php endforeach ?>
        </select><br>
        <!-- <button type="button" onclick="addProduct()">Tambah Produk</button> -->

        <label for="status">Status:</label>
        <input type="text" name="status" required><br>
        <label for="kuantitas">kuantitas</label>
        <input type="number" name="kuantitas" id="kuantitas" min="1" requrired><br>

        <!-- Hidden input to store selected product -->
        <input type="hidden" name="selectedProducts" id="selectedProducts">
        <button type="submit">Create</button>
    </form>
    <a href="/pesanan">Back to Order List</a>

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
</body>

</html>