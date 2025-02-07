<!DOCTYPE html>
<html>

<head>
    <title>Create Order</title>
</head>

<body>
    <h1>Create Order</h1>
    <form action="/pesanan/create" method="post">
        <label for="id">Id:</label>
        <input type="text" name="id" required><br>
        <label for="produk">Produk:</label>
        <select name="produk" id="produk">
            <?php foreach ($produk as $product): ?>
                <option value="<?= $product->getId() ?>">
                    <?= $product->getNama(); ?> <?= $product->getHarga(); ?>
                </option>
            <?php endforeach ?>
        </select>
        <label for="total">Total:</label>
        <input type="text" name="total" required><br>
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>
        <button type="submit">Create</button>
    </form>
    <a href="/pesanan">Back to Order List</a>
</body>

</html>