<!DOCTYPE html>
<html>

<head>
    <title>Update Product</title>
</head>

<body>
    <h1>Update Product</h1>
    <form action="/produk/update" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="PUT">

        <label for="id">Id:</label>
        <input type="text" name="id" value="<?= $product->getId() ?>" required><br>
        <label for="nama">Name:</label>
        <input type="text" name="nama" value="<?= $product->getNama() ?>" required><br>
        <label for="harga">Price:</label>
        <input type="number" name="harga" value="<?= $product->getHarga() ?>" required><br>
        <label for="kategori">Category:</label>
        <input type="text" name="kategori" value="<?= $product->getKategori() ?>" required><br>
        <label for="stok">Stock:</label>
        <input type="number" name="stok" value="<?= $product->getStok() ?>" required><br>
        <button type="submit">Update</button>
    </form>
    <a href="/produk">Back to Catalog</a>
</body>

</html>