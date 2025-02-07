<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="/produk/update/<?= $produk->getId() ?>" method="post">
        <label for="nama">Name:</label>
        <input type="text" name="nama" value="<?= $produk->getNama() ?>" required><br>
        <label for="harga">Price:</label>
        <input type="number" name="harga" value="<?= $produk->getHarga() ?>" required><br>
        <label for="kategori">Category:</label>
        <input type="text" name="kategori" value="<?= $produk->getKategori() ?>" required><br>
        <label for="stok">Stock:</label>
        <input type="number" name="stok" value="<?= $produk->getStok() ?>" required><br>
        <button type="submit">Update</button>
    </form>
    <a href="/produk">Back to Catalog</a>
</body>
</html>