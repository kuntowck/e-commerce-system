<!DOCTYPE html>
<html>

<head>
    <title>Product Detail</title>
</head>

<body>
    <h1>Product Detail</h1>

    <p>ID: <?= $product->getId() ?></p>
    <p>Nama Produk: <?= $product->getNama() ?></p>
    <p>Harga: <?= $product->getHarga() ?></p>
    <p>Kategori: <?= $product->getKategori() ?></p>
    <p>Stok: <?= $product->getStok() ?></p>
    <a href="/produk">Back to Catalog</a>
</body>

</html>